<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Stash;

/**
 * Stashes Controller
 *
 * @property \App\Model\Table\StashesTable $Stashes */
class StashesController extends AppController
{
    var $stashVis = array('Y' => 'Public', 'N' => 'Private');


    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     * @param string|null $order_id Order id.
     */
    public function add($order_id)
    {

        if(!$this->Auth->user())
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }
        $stash = $this->Stashes->newEntity();
        if (isset($order_id)) {

            if ($this->request->is('post','put')) {
                $stash = $this->Stashes->patchEntity($stash, $this->request->data);
                //upload image if user has selected one
                //calls uploadFiles function in AppController.php
                $uploadStatus = $this->uploadFiles('stashedfiles', $this->request->data['uploadfile'],$order_id);
                //if $uploadStatus array contains filepath key, we had success uploading file
                if (array_key_exists('filepath', $uploadStatus)) {
                    $stash->filepath = $uploadStatus['filepath'][0];

                    $stash->filename =  $uploadStatus['filename'][0];
                    $stash->filetype = $uploadStatus['filetype'][0][0];

                    $stash->order_id = $order_id;

                    if ($this->Stashes->save($stash)) {
                        $this->Flash->success('The stash has been saved.');
                        return $this->redirect(['action' => 'view','controller'=>'orders',$order_id]);
                    } else {
                        $this->Flash->error('The stash could not be saved. Please, try again.');
                    }
                } else {
                    $this->request->data['uploadfile'] = null;
                    //if $uploadStatus didn't have a key called filepath then we know there will be a key called errors.
                    //grab the error and display as flash message
                    $this->Flash->error($uploadStatus['errors'][0]);

                }


            }
            //$orders = $this->Stashes->Orders->find('list', ['limit' => 200000]);
            $orders = $this->Stashes->Orders->find('list');
            $this->set('stashVis', $this->stashVis);
            $this->set(compact('stash', 'orders'));
            $this->set('_serialize', ['stash']);
        }
        else {
            $this->Flash->error('You can only create a stash via editing an order record');
            return $this->redirect(['action'=>'index','controller'=>'orders']);
        }

    }
    /**
     * Edit method
     *
     * @param string|null $id Stash id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stash = $this->Stashes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stash = $this->Stashes->patchEntity($stash, $this->request->data);
            if ($this->Stashes->save($stash)) {
                $this->Flash->success('The stash has been saved.');
                return $this->redirect(['action' => 'index','controller'=>'stashes']);
            } else {
                $this->Flash->error('The stash could not be saved. Please, try again.');
            }
        }
        //$orders = $this->Stashes->Orders->find('list', ['limit' => 200000]);
        $orders = $this->Stashes->Orders->find('list');
        $this->set('stashVis', $this->stashVis);
        $this->set(compact('stash', 'orders'));
        $this->set('_serialize', ['stash']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Stash id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null,$order_id)
    {
        $this->request->allowMethod(['post', 'delete', 'put', 'get']);
        $stash = $this->Stashes->get($id);

        if ($this->Stashes->delete($stash)) {
            if(($stash->filename != null))
            {
                $fileFolder = WWW_ROOT."stashedfiles/".$order_id;
                $filePath = $fileFolder.'/'.$stash->filename;
                if (file_exists($filePath))
                    unlink($filePath);

            }
            $this->Flash->success('The stash has been deleted.');
        } else {
            $this->Flash->error('The stash could not be deleted. Try again later.');
        }
        return $this->redirect(['action' => 'view', 'controller' => 'Orders',$order_id]);
    }

    public function sendFile($order_id,$filename) {
        $this->response->file(WWW_ROOT.'stashedfiles/'. $order_id .'/'.$filename, array('download' => true));
        // Return response object to prevent controller from trying to render
        // a view
        return $this->response;
    }

    public function toggleVis($stash_id,$order_id)
    {
        $stash = $this->Stashes->get($stash_id);

        if ($stash->visible == "Y")
            $stash->visible = "N";

        else if ($stash->visible == "N")
            $stash->visible = "Y";

        if ($this->Stashes->save($stash)) {
            $this->Flash->success('Stash visibility has been updated.');
        } else {
            $this->Flash->error('Stash visibility could not be updated. Try again later.');
        }
        return $this->redirect(['action' => 'view', 'controller' => 'Orders',$order_id]);

    }
}
