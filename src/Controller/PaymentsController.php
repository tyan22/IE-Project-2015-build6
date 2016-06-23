<?php
namespace App\Controller;

use App\Controller\AppController;
use Omnipay\Omnipay;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Routing\Router;



/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments */
class PaymentsController extends AppController
{
  public function beforeFilter(Event $event)
  {
      parent::beforeFilter($event);
      //alllow paypalpayment method access to all
      $this->Auth->allow(['paypalpayment']);
  }
  var $transOpts = array('MANUAL - OK'=>'OK', 'MANUAL - CANCELLED' => 'CANCELLED');
  var $paymentOpts = array('1'=>'Cash', '2' => 'EFTPOS', '3' => 'Credit Card', '5'=>'Cheque');
  var $miscOpts = array('Deposit' => 'Deposit','Refund'=>'Refund');

  /**
   * ManualPayment method
   *
   * @return void Redirects on successful add, renders view otherwise.
   * @param string|null $order_id Order id.
   */
  public function manualpayment($order_id)
  {

      if(!$this->Auth->user())
      {
          $this->request->session()->write('Auth.redirect','/'.
              $this->request->params['controller'].'/'.
              $this->request->params['action']);

          $this->Flash->error('Please login to access this page.');
          return $this->redirect(['controller'=>'users', 'action' => 'login']);
      }

      $payment = $this->Payments->newEntity();



      if (isset($order_id)) {
        $this->loadModel('Orders');
        $order = $this->Orders->get($order_id);

          if ($this->request->is('post','put')) {
              $data = [];
              $data['order_id'] = $order_id;
              $data['payment_amount'] = $this->request->data['amount'];
              $data['trans_status'] = "MANUAL - OK";
              $data['item_name'] = "In store payment for order #" . $order_id;
              $data['payment_type'] = $this->request->data['paymentOpts'];
              $data['createdtime'] = Time::now();

              if ($this->request->data['reference'] == null){
                    $randStr = substr(str_shuffle('0123456789') , 0 ,7  );
                    $data['txnid'] = "MAN-".$order_id.$randStr;
              }
              else
                    $data['txnid'] = $this->request->data['reference'];

              if ($this->request->data['miscOpts'] == 'Refund')
                    $data['trans_status'] = "MANUAL - Refund";

              if ($this->request->data['miscOpts'] == 'Deposit')
                   $data['trans_status'] = "MANUAL - DEPOSIT";

              $payment = $this->Payments->patchEntity($payment, $data);

              if ($this->Payments->save($payment)) {
                    $this->Flash->success('The payment has been saved, reference #' . $payment->txnid);
                    if ($this->request->data['miscOpts'] == 'Refund')
                    {
                         $order->balance = $order->balance+$data['payment_amount'];
                         $order->paymentstatus_id = 3;
                    }
                    else if ($this->request->data['miscOpts'] == 'Deposit')
                    {
                        $order->paymentstatus_id = 2;
                        $order->orderstatus_id = 4;
                        $order->deposit_paid = true;
                        $order->balance = $order->balance-$data['payment_amount'];
                    }
                    else if ($order->balance - $data['payment_amount'] == 0){
                      $order->balance = $order->balance-$data['payment_amount'];
                      $order->paymentstatus_id = 4;
                      if ($order->orderstatus_id < 4)
                        $order->orderstatus_id = 4;
                    }
                    else {
                        $order->balance = $order->balance-$data['payment_amount'];
                    }
                    $this->Orders->save($order);
                    return $this->redirect(['action' => 'view','controller'=>'orders',$order_id]);
                } else {
                    $this->Flash->error('The payment could not be saved. Please, try again.');
                }
            }

          $this->set('order', $order);
          $this->set('paymentOpts', $this->paymentOpts);
          $this->set('miscOpts', $this->miscOpts);
          $this->set(compact('payment'));
          $this->set('_serialize', ['payment']);
      }
      else {
          $this->Flash->error('You can only create a manual payment via an existing order');
          return $this->redirect(['action'=>'index','controller'=>'orders']);
      }

  }

  public function editmanpayment($id = null)
  {

      if(!$this->Auth->user())
      {
          $this->request->session()->write('Auth.redirect','/'.
              $this->request->params['controller'].'/'.
              $this->request->params['action']);

          $this->Flash->error('Please login to access this page.');
          return $this->redirect(['controller'=>'users', 'action' => 'login']);
      }
          $payment = $this->Payments->get($id);

          if ($this->request->is(['post','put'])) {
              $data = [];
              $data['order_id'] = $this->request->data['order_id'];
              $data['payment_amount'] = $this->request->data['amount'];
              $data['trans_status'] = $this->request->data['trans_status'];
              $data['item_name'] = "In store payment for order #" . $payment->order_id;
              $data['payment_type'] = $this->request->data['paymentOpts'];
              $data['txnid'] = $this->request->data['txnid'];

              $payment = $this->Payments->patchEntity($payment, $data);


              if ($this->Payments->save($payment)) {
                    $this->Flash->success('The payment has been saved, reference #' . $payment->txnid);
                      return $this->redirect(['action' => 'view','controller'=>'payments',$id]);
                } else {
                    $this->Flash->error('The payment could not be saved. Please, try again.');
                }
            }

          $this->set('paymentOpts', $this->paymentOpts);
          $this->set('miscOpts', $this->miscOpts);
          $this->set('transOpts', $this->transOpts);
          $this->set(compact('payment'));
          $this->set('_serialize', ['payment']);
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

        $this->set('payments', $this->Payments->find()->contain(['Paymenttypes', 'Orders']));
        $this->set('_serialize', ['payments']);
    }

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



        $payment = $this->Payments->get($id, [
            'contain' => ['Orders','Paymenttypes']
        ]);

        $this->loadModel('Customers');
        $cust = $this->Customers->get($payment->order->customer_id);

        $this->set('payment', $payment);
        $this->set('_serialize', ['payment']);

        $this->set('cust', $cust);



    }



    /**
     * Payment method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function paypalpayment()
    {
      $this->autoRender = false;
      $data = [];
      $baseurl = Router::url('/', true);

      $this->loadModel('Settings');
      $settings = $this->Settings->get(1);

      $gateway = Omnipay::create('PayPal_Express');
      //$gateway->setUsername('staticbuzz-facilitator_api1.me.com');
      //$gateway->setPassword('CDGJL5BSNRQ7HGHC');
      //$gateway->setSignature('AFcWxV21C7fd0v3bYYYRCpSSRl31Aqy5OxUe.W.xxeZ-bnSnI5VI23EW');
      $gateway->setUsername($settings->paypal_username);
      $gateway->setPassword($settings->paypal_password);
      $gateway->setSignature($settings->paypal_signature);
      $gateway->setBrandName('Engage Jewellery');
      $gateway->setHeaderImageUrl('http://www.engagejewellery.com.au/wp-content/uploads/2011/07/Engage_logo_4col1.png');
      $gateway->setTestMode(true);

      if ($this->request->is(['post']) && isset($this->request->data['item_amount']))
      {
        $this->request->session()->write('Payment.order_id',$this->request->data['order_number']);
        $this->request->session()->write('Payment.surname',$this->request->data['surname']);
        $this->request->session()->write('Payment.is_deposit',$this->request->data['is_deposit']);

        $data['amount'] = number_format($this->request->data['item_amount'],2);
        $data['currency'] = "AUD";
        $data['description'] = $this->request->data['item_name'];
        //$data['returnUrl'] = "http://orders.engagejewellery.com.au/payments/paypalpayment";
        //$data['cancelUrl'] = "http://orders.engagejewellery.com.au/payments/paypalpayment";
        $data['returnUrl'] = "http://localhost/team19/build6/payments/paypalpayment";
        $data['cancelUrl'] = "http://localhost/team19/build6/payments/paypalpayment";

        $this->request->session()->write('Payment.amount', number_format($this->request->data['item_amount'],2));
        $this->request->session()->write('Payment.desc', $this->request->data['item_name']);



        $request = $gateway->purchase($data)->send();

        return $this->redirect(
           $request->getRedirectUrl()
         );

      }


      else if(isset($this->request->query['token']) && isset($this->request->query['PayerID'])){
        $response = $gateway->completePurchase([
          'transactionId' => $this->request->query['token'],
          'transactionReference' => $this->request->query['PayerID'],
          'amount' => $this->request->session()->read('Payment.amount'),
          'currency' => 'AUD',
        ])->send();

          if ( !$response->isSuccessful())
          {
            $data = [];
            $data['txnid'] = $this->request->query['token'];
            $data['payment_amount'] = $this->request->session()->read('Payment.amount');
            $data['order_id'] = $this->request->session()->read('Payment.order_id');
            $data['item_name'] = $this->request->session()->consume('Payment.desc');
            $data['trans_status'] = "FAIL";
            $data['payment_type'] = 4;
            $payment = $this->Payments->newEntity();
            $payment = $this->Payments->patchEntity($payment, $data);
            $payment->createdtime = Time::now();
            if ($this->Payments->save($payment))
            $this->Flash->error($response->getMessage());
          }
          else {
            $data = [];
            $data['txnid'] = $this->request->query['token'];
            $data['payment_amount'] = $this->request->session()->read('Payment.amount');
            $data['order_id'] = $this->request->session()->read('Payment.order_id');
            $data['item_name'] = $this->request->session()->consume('Payment.desc');
            $data['trans_status'] = "OK";
            $data['payment_type'] = 4;
            $payment = $this->Payments->newEntity();
            $payment = $this->Payments->patchEntity($payment, $data);
            $payment->createdtime = Time::now();

            $orderModel = TableRegistry::get('Orders');
            $order = $orderModel->get($data['order_id'],['contain'=>['Customers']]);

            if ($this->Payments->save($payment)){
                 $this->Flash->success("Payment of $" . $this->request->session()->consume('Payment.amount') . " successful. Your reference number: ". $this->request->query['token']);
                 if (!empty($order->customer->email) && $order->customer->email != null){
                 $email = new Email();
                 $email->template('default', 'engage'); //view, layout
                 $email->emailFormat('html');
                 $email->from('noreply@orders.engagejewellery.com.au', 'Engage Jewellery');
                 $email->transport('default');
                 $email->subject('Engage Jewellery: Payment confirmed');
                 $email->to($order->customer->email);
                 $email->addTo('admin@orders.engagejewellery.com.au');
                 $email->viewVars(['baseurl'=>$baseurl,'id'=>$order->customer->id,'email'=>$order->customer->email,'firstname'=>$order->customer->firstname, 'message'=>'Thank you for your online payment of ' . sprintf('AUD %.2f', $payment->payment_amount) . '. Your receipt number is ' . $payment->txnid.'.
                 Engage Jewellery will be in touch when your order is complete. Feel free to contact us at
                 admin@engagejewellery.com.au should you have any questions. Regards, the team at Engage Jewellery.']);
                 $email->send();
               }
            }
            if ($this->request->session()->consume('Payment.is_deposit')) {
                $order->deposit_paid = true;
                $order->paymentstatus_id = 2;
                $order->orderstatus_id = 4;
            }
            else {
                $order->orderstatus_id = 4;
              if ($order->balance - $payment->payment_amount > 0)
                 $order->paymentstatus_id = 3;
              else {
                 $order->paymentstatus_id = 4;
              }
            }
            $order->balance = ($order->quote - $payment->payment_amount);
            $orderModel->save($order);
          }

         return $this->redirect(['controller'=>'orders', 'action' => 'custview']);

      }
      else {
        return $this->redirect(['controller'=>'orders', 'action' => 'custview']);
      }

    }

}
