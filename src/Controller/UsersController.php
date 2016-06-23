<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Email\Email;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add','login','logout','vieworder','custview']);

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

        $this->set('users', $this->Users->find()->contain(['Groups']));
        $this->set('_serialize', ['users']);
    }

    public function login()
    {
        //find how many users exist
        $count = $this->Users->find()->count();
        //if no users exist, redirect to add user page (will be set to create admin access level user)
        if ($count == 0) {
            $this->Flash->error(__("Please create initial admin user!"));
            return $this->redirect(['controller' => 'Users',
                'action' => 'add','init'=>'y']);
        }

        //set redirect URL even if we come in directly to /users/login
        $isAuthRedi = $this->request->session()->read('Auth.redirect');
        if (!$isAuthRedi)
            $this->request->session()->write('Auth.redirect','/pages/start');


        if ($this->request->is('post')) {

            //check if user is authenticated
            $user = $this->Auth->identify();
            if ($user) {
                //if we are authenticated, set user session variable and redirect as configured
                $this->Auth->setUser($user);

                if ($this->request->session()->read('Auth.redirect') != "/users/login" &&
                    $this->request->session()->read('Auth.redirect') != "/"
                ) {
                    return $this->redirect($this->request->session()->consume('Auth.redirect'));
                } else
                    return $this->redirect(['controller' => 'Pages',
                        'action' => 'display', 'start']);

            }
            else {
                $this->Flash->error(__('Invalid username or password, try again'));
          }
        }
        //if not post
        else {
            $user = $this->Auth->identify();


            if ($user) {
                //if we are authenticated, set user session variable and redirect as configured
                if ($this->request->session()->read('Auth.redirect') == "/pages/start"){
                    return $this->redirect(['controller' => 'Pages',
                        'action' => 'display', 'start']);
                }
                else if ($this->request->session()->read('Auth.redirect') != "/users/login" &&
                    $this->request->session()->read('Auth.redirect') != "/"
                ) {
                    return $this->redirect($this->request->session()->consume('Auth.redirect'));
                } else
                    return $this->redirect(['controller' => 'Pages',
                        'action' => 'display', 'start']);
            }


        }

    }

    public function logout()
    {
        $this->request->session()->delete('Auth');
        $this->request->session()->delete('Auth.redirect');
        $this->request->session()->delete('User');
        $this->request->session()->renew();

        $this->Auth->logout();

        return $this->redirect(['controller' => 'Users',
            'action' => 'login']);

    }

    public function forgot()
    {
        if ($this->request->is('post')) {

            //get the user that matches email given
            $res = $this->Users
                ->find()
                ->where(['email' => $this->request->data['email']])
                ->first();
            if ($res != null)
            {
            //create a random password with 10 characters (non-repeating).
            $newpassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 10 );

            $user = $this->Users->patchEntity($res,
                [
                    'password' => $newpassword
                ]);
            //now update the password in the database.
            $this->Users->save($user);

            //create new email object and its configurations
            $email = new Email();
            $email->sender('noreply@orders.engagejewellery.com.au', 'Engage Jewellery');
            $email->transport('default');

            //attempt to send email
            try {
                $res = $email->from(['noreply@orders.engagejewellery.com.au' => 'Engage Jewellery'])
                    ->to($this->request->data['email'])
                    ->subject('Your Engage Jewellery password has been reset')
                    ->send('Your temporary password is: '.$newpassword . '. You can change this when you log in next.');
                $this->Flash->set(__('Your password has been reset and emailed to '.$this->request->data['email']));
                //display error if email doesnt send
            } catch (Exception $e) {
                $this->Flash->error(__($e->getMessage()));
            }
          }
          else {
            $this->Flash->error(__('No record of user with email address: '.$this->request->data['email']));
          }
            return $this->redirect(['controller' => 'Users',
                'action' => 'login']);


        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
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
        if (!$id) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->Users->get($id, [
            'contain' => ['Groups']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if(!$this->Auth->user() && !isset($this->request->query['init']))
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }

        //set the access level of the logged in user to access in view
        $this->set('loggedInLevel', $this->Auth->User('group_id'));
        //find how many users exist
        $count = $this->Users->find()->count();
        //set user count so we can use it in view
        $this->set('count',$count);
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                if ($count == 0)
                    return $this->redirect(['controller'=>'Settings', 'action' => 'add','init'=>'y']);
                if ($this->Auth->User)
                    return $this->redirect(['action' => 'index']);
                else
                    return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $groups = $this->Users->Groups->find('list');
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
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

        //set the access level of the logged in user to access in view
        $this->set('loggedInLevel', $this->Auth->User('group_id'));
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $groups = $this->Users->Groups->find('list');
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
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
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success('The user has been deleted.');
        } else {
            $this->Flash->error('The user could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }


    public function isAuthorized($user)
    {

        // All registered users can add and view users and reset password
        if ($this->request->action === 'add' ||  $this->request->action === 'forgot') {
            if ($this->Auth->User('group_id') === '1' || $this->Auth->User('group_id') === '2')
                return true;
            else
                return false;
        }

        // Only the owner of a user can view, edit and delete it
        if (in_array($this->request->action, ['view', 'edit', 'delete'])) {
            $selectedId = (int)$this->request->params['pass'][0];
            if ($this->Users->isOwnedBy($selectedId, $user['id'])) {
                return true;
            }
        }
        //if we get to here, check if already authorised from AppController or not, and return that
        return parent::isAuthorized($user);
    }
}
