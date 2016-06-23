<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['custedit','getCustsWithBDay','getCustsWithZodiac']);

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



        $this->set('customers', $this->Customers->find());
        $this->set('_serialize', ['customers']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action'].'/'.
                $id
              );
            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }

        $customer = $this->Customers->get($id, [
            'contain' => ['Orders','States','Titles','Anniversaries','Zodiacbirthstones','Monthbirthstones']
        ]);

        $customer->accessed = Time::now();
        $customer = $this->Customers->patchEntity($customer, [$customer->accessed], []);
        $this->Customers->save($customer);

        $this->set('customer', $customer);
        $this->set('_serialize', ['customer']);



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

        $customer = $this->Customers->newEntity();

        $time = Time::now()->year-15;
        $this->set('time',$time);

        //for states dropdown
        $states = $this->Customers->States->find('list');
        $this->set(compact('customer', 'states'));

        //for titles dropdown
        $titles = $this->Customers->Titles->find('list');
        $this->set(compact('customer', 'titles'));

        //for zodiacs dropdown
        $zodiacs = $this->Customers->Zodiacbirthstones->find('list');
        $this->set(compact('customer', 'zodiacs'));


        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->data(), [
                'associated' => ['States','Titles','Zodiacbirthstones','Monthbirthstones']]);

            //check if we have bday data from form, and if so,
            // convert to CakePHP date format for saving as the dob property of customer
            if ($this->request->data['bday'] != null) {
                // Create from a string datetime.
                $time = Time::createFromFormat(
                    'd-m-Y',
                    $this->request->data['bday']
                );
                $customer->dob = $time;
            }
            else
                $customer->dob = null;

            //access virtual properties in customer model and assign to actual fields.
            $customer->zodiac_id = $customer->zodiacSign;
            $customer->monthbirthstone_id = $customer->birthMonthId;

            $customer->accessed = Time::now();
            $customer->modified = Time::now();

            if ($this->Customers->save($customer)) {
                $this->Flash->success('The customer '.$customer->fullName.' has been saved.');
                if (isset($this->request->query['o']))
                  return $this->redirect(['controller'=>'Orders','action' => 'add',$customer->id,'o'=>'y']);
                else
                  return $this->redirect(['action' => 'view',$customer->id]);
            } else {
                $this->Flash->error('The customer '.$customer->fullName.' could not be saved. Please, try again.');
            }
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);


    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action'].'/'.
                $id
              );

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }
        $time = Time::now()->year-15;
        $this->set('time',$time);
        $customer = $this->Customers->get($id, [
            'contain' => ['Zodiacbirthstones']
        ]);

        //for states dropdown
        $states = $this->Customers->States->find('list');
        $this->set(compact('customer', 'states'));

        //for titles dropdown
        $titles = $this->Customers->Titles->find('list');
        $this->set(compact('customer', 'titles'));

        //for zodiacs dropdown
        $zodiacs = $this->Customers->Zodiacbirthstones->find('list');
        $this->set(compact('customer', 'zodiacs'));

        if ($this->request->is(['patch', 'post', 'put'])) {

            $customer->modified = Time::now();
            $customer->accessed = Time::now();
            $customer = $this->Customers->patchEntity($customer, $this->request->data(), [
                'associated' => ['States','Titles','Zodiacbirthstones','Monthbirthstones']]);

            //check if we have bday data from form, and if so,
            // convert to CakePHP date format for saving as the dob property of customer
            if ($this->request->data['bday'] != null) {
                // Create from a string datetime.
                $time = Time::createFromFormat(
                    'd-m-Y',
                    $this->request->data['bday']
                );
                $customer->dob = $time;
            }
            else
                $customer->dob = null;

            //access virtual properties in customer model and assign to actual fields.
            $customer->zodiac_id = $customer->zodiacSign;
            $customer->monthbirthstone_id = $customer->birthMonthId;

            if ($this->Customers->save($customer)) {
                $this->Flash->success('The customer '.$customer->fullName.' has been saved.');

                return $this->redirect(['action' => 'view',$customer->id]);
            } else {
                $this->Flash->error('The customer '.$customer->fullName.' could not be saved. Please, try again.');
            }
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success('The customer '.$customer->fullName.' has been deleted.');
        } else {
            $this->Flash->error('The customer '.$customer->fullName.' could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function custedit()
    {

        $data = [];

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $cust = $this->Customers->get($this->request->query['cust_id']);

            $this->request->data['phone'] = $this->request->query['phone'];
            $this->request->data['email'] = $this->request->query['email'];

            $cust = $this->Customers->patchEntity($cust, $this->request->data);
            if ($result = $this->Customers->save($cust)) {
                $this->response->body('<p class="alert alert-success">Updated Successfully</p>');
                //echo $result->id;
            } else {
                $this->response->body('<p class="alert alert-danger">Update Failed</p>');
                //print_r($emp);
            }

            return $this->response;
        }

        $this->set(compact('data'));
        $this->set('_serialize', 'data');

    }

    public function getCustsWithBDay()
    {

      $query = $this->Customers->find()->where(['mailing_list'=>true])->contain(['Monthbirthstones']);
      $query->select();

      $results = [];

      foreach ($query as $cust) {
        if (!empty($cust->dob) && $cust->dob != null){
          $time = new Time($cust->dob);
          $now = Time::now();

          //grabs all custs with bdays that are exactly one month away
          if (($now->day - $time->day + 0) === 0 && ($now->month - $time->month + 0) === -1)
          {
            array_push($results,$cust);
          }
        }
      }


      if (!empty($this->request->query['token']) && $this->request->query['token'] === 'w331r4dsafSA9A77sasxcdj1'){
        $this->loadModel('Automail');
        $automail = $this->Automail->get(2);//id 2 is birthday automail

        $now = Time::now();
        $monthid = $now->month;
        $msg_txt = "";

        $this->loadModel('AutomailMsgs');


        $msg = $this->AutomailMsgs->find()->where(['id'=>$monthid])->first();
        $msg_txt = $msg->msg;

        $automail->description = $msg_txt;

        $this->loadModel('Settings');
        $settings = $this->Settings->get(1);


        $baseurl = Router::url('/', true);

        echo $this->request->query['token'];
          //iterate through and send all emails
        foreach ($results as $cust)
        {
          if ($automail->cust_group == "All" || ($cust->cust_type == $automail->cust_group))
          {
            if (!empty($cust->email) && $cust->email != null)
            {
              $email = new Email();
              $email->template('annivs', 'engage') //view, layout
              ->emailFormat('html')
              ->to($cust->email)
              ->transport('default')
              ->viewVars(['firstname' => $cust->firstname,
              'id' => $cust->id,
              'email' => $cust->email,
              'surname' => $cust->surname,
              'headline' => $automail->headline,
              'title' => $automail->title,
              'description' => $automail->description,
              'promoimg' => $automail->image,
              'aboutengage' => $automail->aboutengage,
              'website' => $settings->website,
              'adminemail' => $settings->admin_email,
              'phone' => $settings->phone,
              'baseurl' => $baseurl,
              'type' => 'bday'])
              ->from('noreply@orders.engagejewellery.com.au')
              ->subject($automail->title)
              ->helpers(['Html'])
              ->send();
            }
         }
        }
      }

      $this->set('customers',$results);
      $this->set('_serialize',array('customers'));
    }

    public function getCustsWithZodiac()
    {
      $zodiacNow = "";
      $query = $this->Customers->find()->where(['mailing_list'=>true])->contain(['Zodiacbirthstones']);
      //$query->select(['firstname','surname','email','phone','zodiac_id','zodiacbirthstone']);
      $query->select();
      $results = [];

      //call the getZodiac method defined in AppController (moved it there so we can reuse it elsewhere)
      $zodiacNow = $this->getZodiac();

      //NB: do this on the 15th of each month via cron job

      foreach ($query as $cust) {
        if (!empty($cust->zodiac_id) && $cust->zodiac_id != null){

          if ($zodiacNow === $cust->zodiac_id)
          {
            array_push($results,$cust);
          }
        }
      }

      if (!empty($this->request->query['token']) && $this->request->query['token'] === '1QfsdfhTTasl2cd8WS7hYs81'){
         $baseurl = Router::url('/', true);

         $this->loadModel('Automail');
         $automail = $this->Automail->get(1);//id 1 is zodiac automail

         $this->loadModel('Settings');
         $settings = $this->Settings->get(1);

         $this->loadModel('AutomailMsgs');
         $msg = $this->AutomailMsgs->find()->where(['id'=>($zodiacNow + 12)])->first();
         $msg_txt = $msg->msg;

         $automail->description = $msg_txt;

          echo $this->request->query['token'];
      //iterate through and send all emails
      foreach ($results as $cust)
      {
        if ($automail->cust_group == "All" || ($cust->cust_type == $automail->cust_group))
        {
          print_r($cust->email);

          if (!empty($cust->email) && $cust->email != null)
          {


            $email = new Email();
            $email->template('annivs', 'engage') //view, layout
            ->emailFormat('html')
            ->to($cust->email)
            ->transport('default')
            ->viewVars(['firstname' => $cust->firstname,
            'id' => $cust->id,
            'email' => $cust->email,
            'surname' => $cust->surname,
            'headline' => $automail->headline,
            'title' => $automail->title,
            'description' => $automail->description,
            'promoimg' => $automail->image,
            'aboutengage' => $automail->aboutengage,
            'website' => $settings->website,
            'adminemail' => $settings->admin_email,
            'phone' => $settings->phone,
            'baseurl' => $baseurl,
            'type'=>'zodiac'])
            ->from('noreply@orders.engagejewellery.com.au')
            ->subject($automail->title)
            ->helpers(['Html'])
            ->send();
          }
         }
       }
      }

      $this->set('customers',$results);
      $this->set('_serialize',array('customers'));
    }


}
