<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {



        $validcust = false;
        $order = "not found";
        $custname = "none";
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }

        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));




        if(!$this->Auth->user() && $page != "home" && $page != "vieworder")
        {
            $this->request->session()->write('Auth.redirect','/'.
                $this->request->params['controller'].'/'.
                $this->request->params['action']);

            $this->Flash->error('Please login to access this page.');
            return $this->redirect(['controller'=>'users', 'action' => 'login']);
        }

        if ($page == "start") {
            //load the search component
            $this->loadComponent('Search');

            //load the models
            $orderModel = TableRegistry::get('Orders');
            $vendorModel = TableRegistry::get('Vendors');
            $custModel = TableRegistry::get('Customers');

            //populate arrays using the search component
            $recentCustomers = $this->Search->findLastAccessedCust($custModel)->toArray();
            $recentOrders = $this->Search->findLastAccessedOrder($orderModel)->toArray();
            $recentVendors = $this->Search->findLastAccessedVendor($vendorModel)->toArray();




            //make the arrays available to the view
            $this->set('custs', $recentCustomers);

            $this->set('orders', $recentOrders);

            $this->set('vendors', $recentVendors);

        }

        if ($page == "vieworder" && $this->request->is(['patch', 'post', 'put'])) {
            $ordernum = $this->request->data['order_number'];
            $custname = $this->request->data['customer_surname'];

            return $this->redirect(['controller'=>'orders', 'action' => 'custview',$ordernum,$custname]);

        }


        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }


    }


}
