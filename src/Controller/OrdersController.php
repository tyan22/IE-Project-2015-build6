<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders */
class OrdersController extends AppController
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
        $this->Auth->allow(['custview','acceptquote']);

    }
    var $orderTypes = array('S' => 'Custom', 'R' => 'Repair');

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

        $this->set('orders', $this->Orders->find()->contain(['Customers', 'Vendors', 'Paymentstatuses','Orderstatuses']));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
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
                $id);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }
        $order = $this->Orders->get($id, [
            'contain' => ['Customers', 'Vendors','Paymentstatuses','Orderstatuses','Stashes','Messages','Payments']
        ]);

        $order->accessed = Time::now();
        $order = $this->Orders->patchEntity($order, [$order->accessed], []);
        $this->Orders->save($order);

        $this->set('order', $order);
        $this->set('orderTypes', $this->orderTypes);
        $this->set('_serialize', ['order']);


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
       if (empty($this->request->pass))
        {
            $this->Flash->error('Creating an order is done via either the Customer->edit or Customer->view screens.
             You can click on the desired customer name in the table below to be taken there.');
            return $this->redirect(['controller'=>'Orders', 'action' => 'index']);

        }
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->data);
            $order->modified = Time::now();
            $order->accessed = Time::now();

            $order->description = str_replace(array("\n", "\r"), '', $order->description);


            if ($this->request->data['quote'] != null)
            {
              $order->orderstatus_id = 1;
              $order->paymentstatus_id = 0;
            }
            else {
              $order->orderstatus_id = 0;
              $order->paymentstatus_id = 0;
            }

            if ($this->request->data['acceptedquote'] == 1){
              $order->orderstatus_id = 2;

              if ($this->request->data['quote'] >= 200)
                $order->paymentstatus_id = 1;
              else
                $order->paymentstatus_id = 3;

              $order->balance = $order->quote;
            }
            if ($this->Orders->save($order)) {
                $this->Flash->success('The order has been saved.');
                return $this->redirect(['action' => 'view',$order->id]);
            } else {
                $this->Flash->error('The order could not be saved. Please, try again.');
            }
        }
        $customer = $this->Orders->Customers->get($this->request->pass[0],[
            'contain' => ['States']]);
        $customers = $this->Orders->Customers->find('list');
        $vendors = $this->Orders->Vendors->find('list');
        $paymentstatuses = $this->Orders->Paymentstatuses->find('list');
        $orderstatuses = $this->Orders->Orderstatuses->find('list');

        $this->set('orderTypes', $this->orderTypes);
        $this->set('customer', $customer);
        $this->set(compact('order', 'customers', 'vendors','paymentstatuses','orderstatuses'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
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
                $id);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }

        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        $oldquote = $order->quote;
        if ($this->request->is(['patch', 'post', 'put'])) {
          $customer = $this->Orders->Customers->get($order->customer_id,[
              'contain' => ['States']]);
            $order = $this->Orders->patchEntity($order, $this->request->data);
            $order->accessed = Time::now();
            $order->modified = Time::now();

            if ($this->request->data['quote'] != null && $this->request->data['quote'] != $oldquote)
               $order->orderstatus_id = 1;

            if ($this->request->data['acceptedquote'] == 1 && $order->orderstatus_id < 2){
              $order->orderstatus_id = 2;
              if ($this->request->data['quote'] >= 200 )
                  $order->paymentstatus_id = 1;
              else
                  $order->paymentstatus_id = 3;
              }

              $order->description = str_replace(array("\n", "\r"), '', $order->description);

            if ($this->Orders->save($order)) {
                if ($order->orderstatus_id == 5)
                {
                  $baseurl = Router::url('/', true);
                  if (!empty($customer->email) && $customer->email != null)
                  {
                    $email = new Email();
                    $email->template('default', 'engage'); //view, layout
                    $email->emailFormat('html');
                    $email->from('admin@orders.engagejewellery.com.au', 'Engage Jewellery');
                    $email->transport('default');
                    $email->subject('Your order #' . $order->id . ' is ready to be picked up');
                    $email->to($customer->email);
                    $email->addTo('admin@orders.engagejewellery.com.au');
                    $email->viewVars(['baseurl'=>$baseurl,'id'=>$customer->id,'email'=>$customer->email,'firstname'=>$customer->firstname, 'message'=>'Your order has been completed and is now ready for collection at Engage Jewellery at your convenience. Kindest regards and see you soon!']);
                    $email->send();
                  }
                  //send a confirmation sms if cust has phone and phone begins with '04', i.e. a mobile number.
                  if (!empty($customer->phone) && $customer->phone != null)
                  {
                    if (substr($customer->phone,0,2) == 04)
                    {
                      $message = "Hi " . $customer->firstname . ", your order #" . $order->id . " is ready! You can collect it at your convenience. Regards, Engage Jewellery";

                      //load the component
                      $this->loadComponent('Sms');

                      //load the models
                      $settingsModel = TableRegistry::get('Settings');
                      $custModel = TableRegistry::get('Customers');
                      $orderModel = TableRegistry::get('Orders');

                      $resp = $this->Sms->sendSingleSms($settingsModel,$custModel,$orderModel,$customer->id,$order->id,$message);
                    }
                  }

                }
                $this->Flash->success('The order has been saved.');
                return $this->redirect(['action' => 'view',$order->id]);
            } else {
                $this->Flash->error('The order could not be saved. Please, try again.');
            }
        }
        $customer = $this->Orders->Customers->get($order->customer_id,[
            'contain' => ['States']]);
        $customers = $this->Orders->Customers->find('list', ['limit' => 200]);
        $vendors = $this->Orders->Vendors->find('list', ['limit' => 200]);
        $paymentstatuses = $this->Orders->Paymentstatuses->find('list', ['limit' => 200]);
        $orderstatuses = $this->Orders->Orderstatuses->find('list', ['limit' => 200]);

        $this->loadModel('Messages');
        $messages = $this->Messages->find()
            ->where(['order_id'=>$id])
            ->toArray();

        $this->set('messages', $messages);

        $this->set('orderTypes', $this->orderTypes);
        $this->set('customer', $customer);

        $this->set(compact('order', 'customers', 'vendors', 'paymentstatuses','orderstatuses'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
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
        $order = $this->Orders->get($id);

        $query = TableRegistry::get('Stashes')->find()
            ->where(['order_id =' => $id]);

        foreach ($query as $stash) {
            $stash->delete($stash->id);
        }

        $nextquery = TableRegistry::get('Messages')->find()
            ->where(['order_id =' => $id]);

        foreach ($nextquery as $message) {
            $message->delete($message->id);
        }

        if ($this->Orders->delete($order)) {

            $this->Flash->success('The order has been deleted.');
        } else {
            $this->Flash->error('The order could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function printorder($id = null)
    {

        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action'].'/'.
                $id);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }

        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        $customer = $this->Orders->Customers->get($order->customer_id,[
            'contain' => ['States']]);
        $orderstatuses = $this->Orders->Orderstatuses->find('list');
        $vendors = $this->Orders->Vendors->find('list');
        $paymentstatuses = $this->Orders->Paymentstatuses->find('list');
        $orderstatuses = $this->Orders->Orderstatuses->find('list');
        $now = Time::now();
        $this->set('order',$order);
        $this->set('customer', $customer);
        $this->set('now',$now);
        $this->set(compact('order', 'customers', 'vendors', 'paymentstatuses','orderstatuses'));


    }

    public function custview()
    {
       $this->loadModel('Settings');
       $settings = $this->Settings->get(1);

       $paypal_enabled = "false";

       if (isset($settings->paypal_username) && !empty($settings->paypal_username) && isset($settings->paypal_password) && !empty($settings->paypal_password)) {
         $paypal_enabled = "true";
       }

        if ($this->request->is('ajax')) {
            $this->disableCache();
        }

        $validcust = false;
        if ( isset($this->request->data['order_number']) && isset($this->request->data['customer_surname'])) {
              $id = $this->request->data['order_number'];
              $name = $this->request->data['customer_surname'];
        }
        else if ( $this->request->session()->read('Payment.order_id') != null)
        {

            $id = $this->request->session()->consume('Payment.order_id');
            $name = $this->request->session()->consume('Payment.surname');
        }
        else {
            $id = null;
            $name = null;
            $this->Flash->error('Session expired. Please re-enter details');
            return $this->redirect(['controller'=>'pages', 'action' => 'vieworder']);
        }

        try {
            $order = $this->Orders->get($id,
                ['contain' => ['Customers','Messages','Payments']
                ]);
            $custname = $order->customer['surname'];

            if ($name === $custname || $name === strtolower($custname) || $name === strtoupper($custname)) {
                $validcust = true;
             }
            else
            {
                $validcust = false;
                $this->Flash->error('Incorrect details. Try again');
                return $this->redirect(['controller'=>'pages', 'action' => 'vieworder']);
            }
        }
        catch (RecordNotFoundException $e)
        {
            $validcust = false;
            $this->Flash->error('Order number not found! Try again');
            return $this->redirect(['controller'=>'pages', 'action' => 'vieworder']);
        }

        if(!$validcust && !$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'pages', 'action' => 'vieworder']);
        }


        $publicstashes = $this->Orders->Stashes->find()
            ->where(['visible'=>'Y','order_id'=>$id])
            ->toArray();

        $this->set('order', $order);
        $this->set('publicstashes',$publicstashes);
        $this->set('orderTypes', $this->orderTypes);
        $this->set('paypal_enabled', $paypal_enabled);
        $this->set('_serialize', ['order']);


    }

    public function acceptquote()
    {
        $baseurl = Router::url('/', true);
        $data = [];

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $order = $this->Orders->get($this->request->query['order_id'],['contain' => ['Customers']]);

            $data = [];
            $data['orderstatus_id'] = 2;

            if ($order->quote >= 200)
              $data['paymentstatus_id'] = 1;
            else
              $data['paymentstatus_id'] = 3;

            $data['balance'] = $order->quote;

            $order = $this->Orders->patchEntity($order, $data);
            $this->Orders->save($order);
            $this->response->body('<h6 class="subheader">Order Status</h6>
               <p id="orderstatus">'.$order->orderStatusName.'</p>
               <h6 class="subheader">Payment Status</h6>
               <p id="paymentstatus">'.$order->paymentStatusName.'</p>');

            $email = new Email();
            $email->template('default', 'engage'); //view, layout
            $email->emailFormat('html');
            $email->from('noreply@orders.engagejewellery.com.au', 'Engage Jewellery');
            $email->transport('default');
            $email->subject('Order #' . $order->id . ': QUOTE ACCEPTED BY CUSTOMER');
            $email->to('admin@orders.engagejewellery.com.au');
            $email->viewVars(['baseurl'=>$baseurl,'id'=>$order->customer->id,'email'=>$order->customer->email,'firstname'=>'admin', 'message'=>'For order #' . $order->id . ' the customer, ' . $order->customer->fullName . ', has accepted the provided quote for $' . $order->quote . '.']);
            $email->send();

            return $this->response;
        }

        $this->set(compact('data'));
        $this->set('_serialize', 'data');

    }
}
