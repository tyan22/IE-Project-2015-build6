<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Event\Event;


/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 */
class InvoicesController extends AppController
{

  public function beforeFilter(Event $event)
  {
      parent::beforeFilter($event);
      $this->Auth->deny(['index','add','delete','view','edit']);
  }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

      if (!empty($this->request->pass))
        $this->set('invoices', $this->Invoices->find()->where(['order_id'=>$this->request->pass[0]]));
      else
        $this->set('invoices', $this->Invoices->find());
      $this->set('_serialize', ['invoices']);
    }

    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Orders', 'Invoiceitems']
        ]);
        $this->set('invoice', $invoice);
        $this->set('_serialize', ['invoice']);
    }

    public function printinvoice($id = null)
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

        $invoice = $this->Invoices->get($id, [
            'contain' => ['Invoiceitems']
        ]);

        $this->loadModel('Orders');
        $order = $this->Orders->get($invoice->order_id);

        $this->loadModel('Customers');
        $customer = $this->Customers->get($order->customer_id);

        $this->set('invoice',$invoice);
        $this->set('order',$order);
        $this->set('customer', $customer);
        $this->set(compact('order', 'customers', 'vendors', 'paymentstatuses','orderstatuses'));


    }


    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      if (empty($this->request->pass))
       {
           $this->Flash->error('Creating an invoice is done via either the Order->edit or Order->view screens.
            You can click on the desired order from the table below to be taken there.');
           return $this->redirect(['controller'=>'Orders', 'action' => 'index']);
       }
       $invoice = $this->Invoices->newEntity();

        if ($this->request->is('post')) {

                  //check if we have bday data from form, and if so,
                  // convert to CakePHP date format for saving as the dob property of customer
                  if ($this->request->data['datepaid'] != null) {
                      // Create from a string datetime.
                      $time = Time::createFromFormat(
                          'd-m-Y',
                          $this->request->data['datepaid']
                      );
                      $invoice->date_paid = $time;
                  }
                  else
                      $invoice->date_paid = null;


            $invoice = $this->Invoices->patchEntity($invoice, $this->request->data);

            if ($this->Invoices->save($invoice)) {
                  $this->Flash->success(__('The invoice has been saved.'));
            } else {
                $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            }

            $errorflag = false;
            $totalcost = 0;

            $this->loadModel('Invoiceitems');
            for($i = 0; $i < count($this->request->data['invoiceitem']); $i++){
              if ($this->request->data['invoiceitem'][$i] != null && $this->request->data['invoiceprice'][$i] != null){
                $invoiceitem = $this->Invoiceitems->newEntity();
                $data = ['invoice_id' => $invoice->id, 'amount_ex_gst' => $this->request->data['invoiceprice'][$i], 'description' => $this->request->data['invoiceitem'][$i]];
                $invoiceitem = $this->Invoiceitems->patchEntity($invoiceitem, $data);
                if (!$this->Invoiceitems->save($invoiceitem)){
                  $this->Flash->error(__('The invoice was saved with errors in invoice items. Please review and edit.'));
                }
                else {
                  $totalcost += $this->request->data['invoiceprice'][$i];
                }
            }
          }
          $this->loadModel('Settings');
          $settings = $this->Settings->get(1);
          $invoice->sub_total = $totalcost;
          $invoice->gst_rate = $settings->gst_rate;
          $invoice->grand_total = ($totalcost + ($totalcost*($settings->gst_rate/100)));
          $this->Invoices->save($invoice);
          return $this->redirect(['action' => 'view',$invoice->id]);
        }
        $this->set(compact('invoice'));
        $this->set('_serialize', ['invoice']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, [
            'contain' => ['Invoiceitems']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->data);
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));
            } else {
                $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
            }


            $errorflag = false;
            $totalcost = 0;

            $this->loadModel('Invoiceitems');
            $this->Invoiceitems->deleteAll(['invoice_id'=>$invoice->id]);

            for($i = 0; $i < count($this->request->data['invoiceitem']); $i++){
              if ($this->request->data['invoiceitem'][$i] != null && $this->request->data['invoiceprice'][$i] != null){
                $invoiceitem = $this->Invoiceitems->newEntity();
                $data = ['invoice_id' => $invoice->id, 'amount_ex_gst' => $this->request->data['invoiceprice'][$i], 'description' => $this->request->data['invoiceitem'][$i]];
                $invoiceitem = $this->Invoiceitems->patchEntity($invoiceitem, $data);
                if (!$this->Invoiceitems->save($invoiceitem)){
                  $this->Flash->error(__('The invoice was saved with errors in invoice items. Please review and edit.'));
                }
                else {
                  $totalcost += $this->request->data['invoiceprice'][$i];
                }
            }
          }
          $invoice->sub_total = $totalcost;
          $invoice->grand_total = ($totalcost + ($totalcost*($invoice->gst_rate/100)));
          $this->Invoices->save($invoice);
          return $this->redirect(['action' => 'view',$invoice->id]);
        }

        $this->set(compact('invoice'));
        $this->set('_serialize', ['invoice']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->Invoices->get($id);
        if ($this->Invoices->delete($invoice)) {
            $this->loadModel('Invoiceitems');
            $this->Invoiceitems->deleteAll(['invoice_id'=>$invoice->id]);
            $this->Flash->success(__('The invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
