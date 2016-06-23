<?php
    $this->assign('title', "Customer $customer->fullName");
    $this->Html->addCrumb('Customers', '/customers');
    $this->Html->addCrumb('View Customer', ['controller' => 'Customers', 'action' => 'view',$customer->id]);
?>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


        <li><?= $this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit Customer')),
           ['controller' => 'Customers', 'action' => 'edit',$customer->id],
           array('escape'=>false)) ?>
        </li>

        <li>
        <?php
        echo $this->Form->postLink(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Customer'),
                array('action' => 'delete', $customer->id),
                array('escape'=>false,'confirm'=>
                __('Are you sure you want to delete customer {0} {1}?',
                $customer->firstname, $customer->surname))
           );
        ?>
       </li>

       <li>
         <?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add New Anniversary')),
         ['controller' => 'Anniversaries', 'action' => 'add','customer_id' => $customer->id],array('escape'=>false)) ?>
       </li>

       <li>
                <?= $this->Html->link(
                $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add New Order')),
                ['controller' => 'Orders', 'action' => 'add',$customer->id],array('escape'=>false)) ?>
              </li>

    </ul>
</div>
<div class="customers view large-10 medium-9 columns ">
    <h2 class="bold"><?= h($customer['title']['name']) ?> <?= h($customer->fullName) ?></h2>

     <div class="row">
        <div class="large-6 columns ">
            <table class="table dataTable card border-blue-left" cellspacing="0">
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td colspan="2"><?= h($customer->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td colspan="2"><?= h($customer->email) ?></td>
                 </tr>
                 <tr>
                    <th><?= __('Address') ?></th>
                    <td colspan="2"><?= h($customer->address) ?></td>
                 </tr>
                 <tr>
                     <th><?= __('Suburb') ?></th>
                     <td colspan="2"><?= h($customer->suburb) ?></td>
                  </tr>
                  <tr>
                    <th><?= __('State') ?></th>
                    <td colspan="2"><?= $customer->has('state') ? h($customer['state']['name']) : '' ?></td>
                  </tr>
                  <tr>
                     <th><?= __('Postcode') ?></th>
                     <td colspan="2"><?= h($customer->postcode) ?></td>
                  </tr>
                  </table>

                  <table class="table dataTable  card border-blue-left">
                        <tr>
                          <th><?= __('Comments') ?></th>
                        </tr>
                        <tr>
                        <?php
                          if (!empty($customer->comments))
                            echo "<td>".h($customer->comments)."</td>";
                          else
                            echo "<td>There are no comments for this customer</td>";
                          ?>
                        </tr>
                  </table>
                  </div>


                  <div class="medium-3 large-2 small-5 columns dates end">
                              <?php if ($customer->dob == null)
                                 {
                                  echo "<h6 class='opportunity'>Birth month unknown</h6>";
                                  echo $this->Html->image('question.png',['alt'=>'Question icon','class'=>'img-responsive']);
                                  echo "<span class='opportunity'><i class='glyphicon glyphicon-question-sign right-pad-5px'></i>Consider asking about date of birth on next contact</span>";
                                 }
                                 else {
                              echo "<h6 class='subheader'>Birthstone for <br /><span class='bold'>".$customer->birthMonth."</span></h6>";
                              echo "<p class='subheader bold'>".$customer->monthbirthstone['name']."</p>";
                              echo $this->Html->image('monthbirthstones/'.$customer->monthbirthstone['image'], ['class'=>'img-responsive','alt' => 'Birthstone '.$customer->monthbirthstone['name']]);
                              }
                              ?>
                          </div>
                          <div class="medium-3 large-2 small-5 columns dates end">
                          <?php if ($customer->zodiac_id == null)
                                         {
                                              echo "<h6 class='opportunity'>Zodiac unknown</h6>";
                                              echo $this->Html->image('question.png',['alt'=>'Question icon','class'=>'img-responsive'] );
                                             echo "<span class='opportunity'><i class='glyphicon glyphicon-question-sign right-pad-5px'></i>Consider asking about zodiac sign or birthday on next contact</span>";
                                         }
                                         else {
                                      echo "<h6 class='subheader'>Birthstone for <br /><span class='bold'>".$customer->zodiacbirthstone['sign']."</span></h6>";
                                      echo "<p class='subheader bold'>".$customer->zodiacbirthstone['name']."</p>";
                                      echo $this->Html->image('zodiacstones/'.$customer->zodiacbirthstone['image'], ['class'=>'img-responsive','alt' => 'Zodiac birthstone '.$customer->zodiacbirthstone['name']]);
                                  }
                                  ?>
                          </div>

                  </div>
                  <div class="row">
                  <div class="large-6 columns">
                  <?php
                    echo "<table class='table dataTable card border-blue-left'>
                        <tr>
                           <th>". __('Birthday') ."</th>
                        </tr>
                        <tr>
                        <td>";
                             if (!empty($customer->dob)){
                                echo $customer->dob->i18nFormat('dd-MMM-YYYY');
                                }
                             else
                                echo "<span class='opportunity'><i class='glyphicon glyphicon-question-sign right-pad-5px'></i>Birthday unknown. Consider enquiring with customer about date of birth.</span>";
                        echo "</td>
                        </tr>
                  </table>
                  </div>" ;
                        ?>

                   <div class="large-5 columns end">
                     <table class='table dataTable card border-blue-left'>
                         <tr>
                           <th> <?= __('Created') ?> </th>
                           <th> <?= __('Modified') ?> </th>
                        </tr>

                        <tr><td><?= $this->Format->formatDateTime($customer->created) ?></td>

                         <?php
                              if (!empty($customer->modified))
                              {
                                  echo "<td>". $this->Format->formatDateTime($customer->modified)."</td>";
                              }
                              else
                              {
                                  echo '<td>'. $this->Format->formatDateTime($customer->created). '</td>';
                              }
                              ?>
                              </tr>
                          </table>

                   </div>

    </div>

            <br />
        <div class="column large-11 card border-blue-left">
            <h4 class="subheader"><?= __('Customer\'s Anniversaries') ?></h4>
            <?php if (!empty($customer->anniversaries)): ?>
            <table class="table dataTable no-footer card" cellspacing="0">
                <tr>
                    <th><?= __('Anniversary Type') ?></th>
                    <th class="hide-for-small-down"><?= __('Day/Month') ?></th>
                    <th class="hide-for-small-down"><?= __('Year') ?></th>


                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($customer->anniversaries as $anns){
                echo "<tr>";

                    echo "<td> ".$anns->anniversaryType."</td>";
                    ?>
                    <td class="hide-for-small-down"><?= $anns->anniversarydate->i18nFormat('dd-MMM') ?></td>
                    <td class="hide-for-small-down">
                    <?php
                    if($anns->yearknown==true)
                        echo $anns->anniversarydate->i18nFormat('YYYY');
                    else
                        echo "Unknown";
                    ?>
                    </td>


                    <td class="actions">
                    <?php
                         echo $this->Form->postLink(
                                   $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete'),
                                        ['controller' => 'Anniversaries','action' => 'delete', $anns->id],
                                        array('escape'=>false,'class' => 'btn btn-danger'),
                                        __('Are you sure you want to delete this '. $anns->anniversaryType.'?')
                                   );
                        ?>

                    </td>
                </tr>

                <?php } ?>
            </table>
            <?php else: ?>
                       <span class='opportunity'><i class='glyphicon glyphicon-question-sign right-pad-5px'></i>No anniversaries found.<br />Consider enquiring with customer about anniversaries and special dates</span>
            <?php endif; ?>
</div>
     <br />
        <div class="column large-11 card border-blue-left">
            <h4 class="subheader"><?= __('Customer\'s Orders') ?></h4>
            <?php if (!empty($customer->orders)): ?>
            <table class="table dataTable no-footer card" cellspacing="0">
                <tr>
                    <th><?= __('Order #') ?></th>
                    <th class="hide-for-medium-down"><?= __('Quote') ?></th>
                    <th><?= __('Order Status') ?></th>
                    <th class="hide-for-medium-down"><?= __('Payment Status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($customer->orders as $custOrder){
                echo "<tr>";

                    echo "<td> ".$custOrder->id."</td>";

                    if ($custOrder->quote != null)
                        echo '<td class="hide-for-medium-down">'.$this->Number->currency($custOrder->quote).'</td>';
                    else
                        echo '<td class="hide-for-medium-down">N/A</td>';
                        ?>
                    <td><?= $custOrder->orderStatusName ?></td>
                    <td class="hide-for-medium-down"><?= $custOrder->paymentStatusName ?></td>



                    <td class="actions">
                <?php
                echo $this->Html->link(
                     '<i class="glyphicon glyphicon-eye-open right-pad-0px"></i>',
                     ['controller'=>'Orders','action' => 'view', $custOrder->id],
                     ['class'=>'btn btn-info','escape'=>false]
                    );
                ?>&nbsp;&nbsp;
                 <?php
                echo $this->Html->link(
                     '<i class="glyphicon glyphicon-edit right-pad-0px"></i>',
                     ['controller'=>'Orders','action' => 'edit',$custOrder->id],
                     ['class'=>'btn btn-warning','escape'=>false]
                    );
 ?>
                    </td>
                </tr>

                <?php } ?>
            </table>
            <?php else: ?>
                       <span class='opportunity'><i class='glyphicon glyphicon-question-sign right-pad-5px'></i>No orders found for this customer.
                       Do you need to <?= $this->Html->link(__('add one now'),['controller' => 'Orders', 'action' => 'add',$customer->id]) ?> ?</span>
            <?php endif; ?>
</div>
