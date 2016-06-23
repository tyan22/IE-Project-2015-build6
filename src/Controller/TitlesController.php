<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Titles Controller
 *
 * @property \App\Model\Table\TitlesTable $Titles
 */
class TitlesController extends AppController
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
        $this->set('titles', $this->Titles->find());
        $this->set('_serialize', ['titles']);
    }

    /**
     * View method
     *
     * @param string|null $id Title id.
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
        }        $title = $this->Titles->get($id, [
            'contain' => []
        ]);
        $this->set('title', $title);
        $this->set('_serialize', ['title']);
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
        $title = $this->Titles->newEntity();
        if ($this->request->is('post')) {
            $title = $this->Titles->patchEntity($title, $this->request->data);
            if ($this->Titles->save($title)) {
                $this->Flash->success('The title has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The title could not be saved. Try again later.');
            }
        }
        $this->set(compact('title'));
        $this->set('_serialize', ['title']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Title id.
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
        $title = $this->Titles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $title = $this->Titles->patchEntity($title, $this->request->data);
            if ($this->Titles->save($title)) {
                $this->Flash->success('The title has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The title could not be saved. Try again later.');
            }
        }
        $this->set(compact('title'));
        $this->set('_serialize', ['title']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Title id.
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
        $title = $this->Titles->get($id);
        if ($this->Titles->delete($title)) {
            $this->Flash->success('The title has been deleted.');
        } else {
            $this->Flash->error('The title could not be deleted. Try again later.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
