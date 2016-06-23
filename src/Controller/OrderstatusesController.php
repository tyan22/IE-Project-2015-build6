<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Orderstatuses Controller
 *
 * @property \App\Model\Table\OrderstatusesTable $Orderstatuses */
class OrderstatusesController extends AppController
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
        $this->set('orderstatuses', $this->Orderstatuses->find());
        $this->set('_serialize', ['orderstatuses']);
    }

    /**
     * View method
     *
     * @param string|null $id Orderstatus id.
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
        $orderstatus = $this->Orderstatuses->get($id, [
            'contain' => ['Orders']
        ]);
        $this->set('orderstatus', $orderstatus);
        $this->set('_serialize', ['orderstatus']);
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
        $orderstatus = $this->Orderstatuses->newEntity();
        if ($this->request->is('post')) {
            $orderstatus = $this->Orderstatuses->patchEntity($orderstatus, $this->request->data);
            if ($this->Orderstatuses->save($orderstatus)) {
                $this->Flash->success('The orderstatus has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The orderstatus could not be saved. Please, try again.');
            }
        }
        $this->set(compact('orderstatus'));
        $this->set('_serialize', ['orderstatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Orderstatus id.
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
        $orderstatus = $this->Orderstatuses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderstatus = $this->Orderstatuses->patchEntity($orderstatus, $this->request->data);
            if ($this->Orderstatuses->save($orderstatus)) {
                $this->Flash->success('The orderstatus has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The orderstatus could not be saved. Please, try again.');
            }
        }
        $this->set(compact('orderstatus'));
        $this->set('_serialize', ['orderstatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Orderstatus id.
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
        $orderstatus = $this->Orderstatuses->get($id);
        if ($this->Orderstatuses->delete($orderstatus)) {
            $this->Flash->success('The orderstatus has been deleted.');
        } else {
            $this->Flash->error('The orderstatus could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
