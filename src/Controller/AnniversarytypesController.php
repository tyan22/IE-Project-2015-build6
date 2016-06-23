<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Anniversarytypes Controller
 *
 * @property \App\Model\Table\AnniversarytypesTable $Anniversarytypes
 */
class AnniversarytypesController extends AppController
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

        $this->set('anniversarytypes', $this->Anniversarytypes->find());
        $this->set('_serialize', ['anniversarytypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Anniversarytype id.
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

        $anniversarytype = $this->Anniversarytypes->get($id, [
            'contain' => ['Anniversaries']
        ]);
        $this->set('anniversarytype', $anniversarytype);
        $this->set('_serialize', ['anniversarytype']);
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

        $anniversarytype = $this->Anniversarytypes->newEntity();
        if ($this->request->is('post')) {
            $anniversarytype = $this->Anniversarytypes->patchEntity($anniversarytype, $this->request->data);
            if ($this->Anniversarytypes->save($anniversarytype)) {
                $this->Flash->success('The anniversary type '.$anniversarytype->type.' has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The anniversary type '.$anniversarytype->type.' could not be saved. Please, try again.');
            }
        }
        $this->set(compact('anniversarytype'));
        $this->set('_serialize', ['anniversarytype']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Anniversarytype id.
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
        $anniversarytype = $this->Anniversarytypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $anniversarytype = $this->Anniversarytypes->patchEntity($anniversarytype, $this->request->data);
            if ($this->Anniversarytypes->save($anniversarytype)) {
                $this->Flash->success('The anniversary type '.$anniversarytype->type.' has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The anniversary type '.$anniversarytype->type.' could not be saved. Please, try again.');
            }
        }
        $this->set(compact('anniversarytype'));
        $this->set('_serialize', ['anniversarytype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Anniversarytype id.
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
        $anniversarytype = $this->Anniversarytypes->get($id);
        if ($this->Anniversarytypes->delete($anniversarytype)) {
            $this->Flash->success('The anniversary type '.$anniversarytype->type.' has been deleted.');
        } else {
            $this->Flash->error('The anniversary type '.$anniversarytype->type.' could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
