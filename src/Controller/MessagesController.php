<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages */
class MessagesController extends AppController
{
    public $components = array('RequestHandler');

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['add', 'index', 'view']);

    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Orders']
        ];
        $this->set('messages', $this->paginate($this->Messages));
        $this->set('_serialize', ['messages']);
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['Orders']
        ]);
        $this->set('message', $message);
        $this->set('_serialize', ['message']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Messages->newEntity();
        $data = [];

        if ($this->request->is('ajax')) {
            $this->autoRender = false;

            $this->request->data['name'] = $this->request->query['name'];
            $this->request->data['msg_date'] = Time::now();
            $this->request->data['message'] = $this->request->query['message'];
            $this->request->data['from_cust'] = $this->request->query['from_cust'];
            $this->request->data['order_id'] = $this->request->query['order_id'];
            $this->loadModel('Orders');
            $order = $this->Orders->get($this->request->query['order_id'], ['contain'=>['Customers']]);
            $baseurl = Router::url('/', true);

            $message = $this->Messages->patchEntity($message, $this->request->data);
            if ($result = $this->Messages->save($message)) {
                $this->response->body('Success');
                if (!empty($order->customer->email) && $order->customer->email != null){
                $email = new Email();
                $email->template('default', 'engage'); //view, layout
                $email->emailFormat('html');
                $email->from('noreply@orders.engagejewellery.com.au', 'Engage Jewellery');
                $email->transport('default');
                $email->subject('New message received for Order #' . $this->request->data['order_id']);
                if (!$this->request->data['from_cust']){
                  $email->to($order->customer->email);
                  $name = $order->customer->firstname;
                }
                else {
                  $name = 'admin';
                  $email->to('admin@orders.engagejewellery.com.au');
                }
                $email->viewVars(['baseurl'=>$baseurl,'id'=>$order->id,'email'=>$order->customer->email,'firstname'=>$name, 'message'=>'There is a new message for order #'.$order->id.'. The message is: <br /><br />"' . $message->message.
                '"<br /><br />For more information or to reply, please view the order at <a href="http://orders.engagejewellery.com.au/vieworder">http://orders.engagejewellery.com.au/vieworder</a>. Have a nice day!'
                ]);
                $email->send();
              }
            } else {
                $this->response->body('Error');
            }
            $msgresp = "";

            if (!$this->request->data['from_cust'])
            {
              $msgresp .= "<tr style='width:100%;display:block;float:right'>";
              $msgresp .= "<td style='float:right'><span style='";
              $msgresp .= "float:right; margin-left:55px;";
              $msgresp .= "' class='alert ";
              $msgresp .= "alert-info  cust-alert'>";
            }
            else
            {
              $msgresp .= "<tr style='width:100%;display:block;float:left'>";
              $msgresp .= "<td style='float:left'><span style='";
              $msgresp .= "float:left; margin-right:55px;";
              $msgresp .= "' class='alert ";
              $msgresp .= "alert-success  cust-alert'>";
            }

            $msgresp .= '<p style="font-weight:bold;font-size:12px;">' . $this->request->data['name'] . "</p><br />";
            $msgresp .= "<p>".$this->request->data['message'] . "</p><br />";
            $msgresp .= "<p style='font-weight:bold;font-size:12px;'>Just now</p>";
            $msgresp .= "</span></td></tr>";

            $this->response->body($msgresp);

            return $this->response;

        }

        $this->set(compact('data'));
        $this->set('_serialize', 'data');

    }

}
