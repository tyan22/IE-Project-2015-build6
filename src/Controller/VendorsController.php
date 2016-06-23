<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Vendors Controller
 *
 * @property \App\Model\Table\VendorsTable $Vendors */
class VendorsController extends AppController
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

        $this->set('vendors', $this->Vendors->find()->contain(['States']));
        $this->set('_serialize', ['vendors']);
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
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
        $vendor = $this->Vendors->get($id, [
            'contain' => ['States', 'Orders']
        ]);

        $vendor->accessed = Time::now();
        $vendor = $this->Vendors->patchEntity($vendor, [$vendor->accessed], []);
        $this->Vendors->save($vendor);

        $this->set('vendor', $vendor);
        $this->set('_serialize', ['vendor']);
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
        $vendor = $this->Vendors->newEntity();
        if ($this->request->is('post')) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
            $vendor->modified = Time::now();
            $vendor->accessed = Time::now();
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success('The vendor '.$vendor->vendor_name.' has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The vendor '.$vendor->vendor_name.' could not be saved. Please, try again.');
            }
        }
        $states = $this->Vendors->States->find('list', ['limit' => 200]);
        $this->set(compact('vendor', 'states'));
        $this->set('_serialize', ['vendor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor id.
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
        $vendor = $this->Vendors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
            $vendor->modified = Time::now();
            $vendor->accessed = Time::now();
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success('The vendor '.$vendor->vendor_name.' has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The vendor '.$vendor->vendor_name.' could not be saved. Please, try again.');
            }
        }
        $states = $this->Vendors->States->find('list', ['limit' => 200]);
        $this->set(compact('vendor', 'states'));
        $this->set('_serialize', ['vendor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
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
        $vendor = $this->Vendors->get($id);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success('The vendor '.$vendor->vendor_name.' has been deleted.');
        } else {
            $this->Flash->error('The vendor '.$vendor->vendor_name.' could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
