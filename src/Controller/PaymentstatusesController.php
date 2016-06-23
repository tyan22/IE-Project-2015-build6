<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Paymentstatuses Controller
 *
 * @property \App\Model\Table\PaymentstatusesTable $Paymentstatuses */
class PaymentstatusesController extends AppController
{

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
        $this->set('paymentstatuses', $this->Paymentstatuses->find());
        $this->set('_serialize', ['paymentstatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Paymentstatus id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }
        $paymentstatus = $this->Paymentstatuses->get($id, [
            'contain' => ['Orders']
        ]);
        $this->set('paymentstatus', $paymentstatus);
        $this->set('_serialize', ['paymentstatus']);
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
        $paymentstatus = $this->Paymentstatuses->newEntity();
        if ($this->request->is('post')) {
            $paymentstatus = $this->Paymentstatuses->patchEntity($paymentstatus, $this->request->data);
            if ($this->Paymentstatuses->save($paymentstatus)) {
                $this->Flash->success('The paymentstatus has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The paymentstatus could not be saved. Please, try again.');
            }
        }
        $this->set(compact('paymentstatus'));
        $this->set('_serialize', ['paymentstatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Paymentstatus id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);
            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }
        $paymentstatus = $this->Paymentstatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentstatus = $this->Paymentstatuses->patchEntity($paymentstatus, $this->request->data);
            if ($this->Paymentstatuses->save($paymentstatus)) {
                $this->Flash->success('The paymentstatus has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The paymentstatus could not be saved. Please, try again.');
            }
        }
        $this->set(compact('paymentstatus'));
        $this->set('_serialize', ['paymentstatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Paymentstatus id.
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
        $paymentstatus = $this->Paymentstatuses->get($id);
        if ($this->Paymentstatuses->delete($paymentstatus)) {
            $this->Flash->success('The paymentstatus has been deleted.');
        } else {
            $this->Flash->error('The paymentstatus could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
