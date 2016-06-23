
<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

    $this->assign('title', 'Engage Jewellery | Check Your Order');


$cakeDescription = 'Engage Jewellery | Check Your Order';
?>



    <div id="content">


        <div class="row">

             <div class="columns medium-6 medium-offset-3 ">
             <div class="row">
                    <div class="small-4 columns">
                           <?= $this->Html->image('rings1.jpg') ?>
                    </div>
                     <div class="small-4 columns">
                           <?= $this->Html->image('rings2.jpg') ?>
                     </div>
                     <div class="small-4 columns">
                             <?= $this->Html->image('rings3.jpg') ?>
                      </div>
             </div>
             <div class="row">
                   <div class="columns card padding-all-30px margin-top-50px large-12 border-blue-left">
                   <h2 class="login-heading">Welcome to Engage Jewellery</h2>

                    <div class="large-8 large-offset-2 columns">
                    <br />
                    <p><i>Please enter your details to proceed to your order</i></p>
                        <?= $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'custview']]); ?>
                         <?= $this->Form->input('order_number',['label' => 'Order Number']) ?>
                         <?= $this->Form->input('customer_surname',['label' => 'Surname']) ?>
                        <?= $this->Form->button($this->Html->tag('i', '', array('style'=>'font-family:FontAwesome;','class' => 'fa-sign-in right-pad-5px')).__('View my order'),['class'=>'btn btn-primary move-right']); ?>
                        <?= $this->Form->end() ?>
                        </div>
                        </div>
                      </div>

               </div>

        </div>
    </div>
    <footer>
    </footer>
</body>
</html>
