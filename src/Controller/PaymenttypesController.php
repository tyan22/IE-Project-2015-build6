<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Paymenttypes Controller
 *
 * @property \App\Model\Table\PaymenttypesTable $Paymenttypes */
class PaymenttypesController extends AppController
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
        $this->set('paymenttypes', $this->Paymenttypes->find());
        $this->set('_serialize', ['paymenttypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Paymenttype id.
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
        $paymenttype = $this->Paymenttypes->get($id, [
            'contain' => ['Payments']
        ]);
        $this->set('paymenttype', $paymenttype);
        $this->set('_serialize', ['paymenttype']);
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
        $paymenttype = $this->Paymenttypes->newEntity();
        if ($this->request->is('post')) {
            $paymenttype = $this->Paymenttypes->patchEntity($paymenttype, $this->request->data);
            if ($this->Paymenttypes->save($paymenttype)) {
                $this->Flash->success('The paymenttype has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The paymenttype could not be saved. Please, try again.');
            }
        }
        $this->set(compact('paymenttype'));
        $this->set('_serialize', ['paymenttype']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Paymenttype id.
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
        $paymenttype = $this->Paymenttypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymenttype = $this->Paymenttypes->patchEntity($paymenttype, $this->request->data);
            if ($this->Paymenttypes->save($paymenttype)) {
                $this->Flash->success('The paymenttype has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The paymenttype could not be saved. Please, try again.');
            }
        }
        $this->set(compact('paymenttype'));
        $this->set('_serialize', ['paymenttype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Paymenttype id.
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
        $paymenttype = $this->Paymenttypes->get($id);
        if ($this->Paymenttypes->delete($paymenttype)) {
            $this->Flash->success('The paymenttype has been deleted.');
        } else {
            $this->Flash->error('The paymenttype could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
