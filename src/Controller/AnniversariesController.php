<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Routing\Router;


/**
 * Anniversaries Controller
 *
 * @property \App\Model\Table\AnniversariesTable $Anniversaries
 */
class AnniversariesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->deny(['edit','view']);
        $this->Auth->allow(['getCustsWithAnnivs']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }


        $this->set('anniversaries', $this->Anniversaries->find()->contain(['Anniversarytypes', 'Customers']));
        $this->set('_serialize', ['anniversaries']);
    }



    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }
        $time = Time::now()->year;
        $this->set('time',$time);
        $anniversary = $this->Anniversaries->newEntity();
        if (isset($this->request->query['customer_id'])) {
            if ($this->request->is('post')) {
                $anniversary = $this->Anniversaries->patchEntity($anniversary, $this->request->data);

                //debug($anniversary,true);

                $daymonth = explode('-',$this->request->data['annidate']);

                if ($this->request->data['yearknown'] == 1)
                {
                    $temptime = Time::createFromFormat(
                        'd-M-Y',
                        $daymonth[0].'-'.$daymonth[1].'-'.$this->request->data['anniyear']
                    );
                }
                else {
                    $temptime = Time::createFromFormat(
                        'd-M-Y',
                        $daymonth[0].'-'.$daymonth[1].'-1902'
                );
                }
                $anniversary->anniversarydate = $temptime;


                if ($this->Anniversaries->save($anniversary)) {
                    $this->Flash->success('The anniversary has been saved.');
                    return $this->redirect(['action'=>'view','controller'=>'customers',$this->request->data['customer_id']]);
                } else {
                    $this->Flash->error('The anniversary could not be saved. Please, try again.');
                }
            }
        }
        else {
                $this->Flash->error('You can only create an anniversary by editing a customer record');
                return $this->redirect(['action'=>'index','controller'=>'customers']);
        }


        if ($this->request->query['customer_id']) {
            $this->set("cust_id", $this->request->query['customer_id']);

        $anniversarytypes = $this->Anniversaries->Anniversarytypes->find('list', ['limit' => 200]);
        $customers = $this->Anniversaries->Customers->find('list', ['limit' => 200]);
        $this->set(compact('anniversary', 'anniversarytypes', 'customers'));
        $this->set('_serialize', ['anniversary']);
        }
    }


    /**
     * Delete method
     *
     * @param string|null $id Anniversary id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if(!$this->Auth->user())
        {
            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $anniversary = $this->Anniversaries->get($id);
        if ($this->Anniversaries->delete($anniversary)) {
            $this->Flash->success('The anniversary has been deleted.');
        } else {
            $this->Flash->error('The anniversary could not be deleted. Please, try again.');
        }
        return $this->redirect($this->referer());

    }

    public function getCustsWithAnnivs()
    {

      $query = $this->Anniversaries->find()
        ->contain(['Anniversarytypes','Customers']);

      $results = [];

      foreach ($query as $anniv) {
          $time = new Time($anniv->anniversarydate);
          $now = Time::now();

          //debug: echo " anniv: ".$time->day . " / " . $time->month;
          //debug: echo " diff: ".($now->day - $time->day + 0) . " / " . ($now->month - $time->month + 0);

          //grabs all anniversaries that are exactly one month away
          if (($now->day - $time->day + 0) === 0 && ($now->month - $time->month + 0) === -1)
          {
            array_push($results,$anniv);
          }

        }


      if (!empty($this->request->query['token']) && $this->request->query['token'] === '1af3dckSDArSW2c2qedfsa'){
        $this->loadModel('Automail');
        $automail = $this->Automail->get(3);//id 3 is anniversary automail

        $this->loadModel('Settings');
        $settings = $this->Settings->get(1);

        $baseurl = Router::url('/', true);
        echo $this->request->query['token'];
        //iterate through and send all emails
        foreach ($results as $anniv)
        {
          if ($automail->cust_group == "All" || ($anniv->customer->cust_type == $automail->cust_group))
          {
            if (!empty($anniv->customer->email) && $anniv->customer->email != null)
            {
              $msg_txt = "There's a very special day coming up! Make your " . strtolower($anniv->anniversarytype->type) . " a perfect one with a gift from Engage Jewellery.";
              $email = new Email();
              $email->template('annivs', 'engage') //view, layout
              ->emailFormat('html')
              ->to($anniv->customer->email)
              ->transport('default')
              ->viewVars(['firstname' => $anniv->customer->firstname,
              'id' => $anniv->customer->id,
              'email' => $anniv->customer->email,
              'surname' => $anniv->customer->surname,
              'headline' => $automail->headline,
              'title' => $automail->title,
              'description' => $msg_txt,
              'promoimg' => $automail->image,
              'aboutengage' => $automail->aboutengage,
              'website' => $settings->website,
              'adminemail' => $settings->admin_email,
              'phone' => $settings->phone,
              'baseurl' => $baseurl,
              'annivtype'=>$anniv->anniversarytype->type,
              'type' => 'anniv'])
              ->from('noreply@orders.engagejewellery.com.au')
              ->subject($automail->title)
              ->helpers(['Html'])
              ->send();
            }
          }
       }
      }

      $this->set('annivs',$results);
      $this->set('_serialize',array('annivs'));
    }
}
