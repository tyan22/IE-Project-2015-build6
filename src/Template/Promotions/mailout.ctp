<?php
    $this->assign('title', "Send Out Promotion");
    $this->Html->addCrumb('Promotions', '/promotions');
    $this->Html->addCrumb('Send Out Promotion', ['controller' => 'Promotions', 'action' => 'mailout',$promotion->id]);
?>
<style>
  ul.nav.navbar-nav li a {color:#9d9d9d !important}
  ul.nav.navbar-nav li.open ul.dropdown-menu li a {color:#444 !important}
  .nav a:visited {color: #6b6b6b !important}
  a:visited:not(#email-prev){color:#444}
  li .btn .btn-info{color:white !important}
</style>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li><?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit Promotion')),
         ['controller' => 'Promotions', 'action' => 'edit',$promotion->id],
         array('escape'=>false)) ?>
      </li>

      <li>
      <?php
      echo $this->Form->postLink(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Promotion'),
              array('action' => 'delete', $promotion->id),
              array('escape'=>false,'confirm'=>
              __('Are you sure you want to delete promotion "{0}"?',
              $promotion->title))
         );
      ?>
     </li>

     <li>
       <?= $this->Html->link(
       $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-envelope right-pad-5px')).$this->Html->tag('span', __('Send Test Email')),
       ['controller' => 'Promotions', 'action' => 'sendtestemail',$promotion->id,'promotion.json'],array('escape'=>false)) ?>
     </li>
     <li>
       <?= $this->Html->link(
       $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-envelope right-pad-5px')).$this->Html->tag('span', __('Send Test SMS')),
       ['controller' => 'Sms', 'action' => 'testSms',$promotion->id],array('escape'=>false)) ?>
     </li>


     <li>
       <?php if ($promotion->include_sms)
          $confmsg = 'Are you sure you want to send out bulk email and sms for promotion';
        else {
          $confmsg = 'Are you sure you want to send out bulk email for promotion';
        }
      echo $this->Form->postLink(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-send right-pad-5px')). __('Send Out Promo'),
                array('action' => 'sendbulkemail', $promotion->id),
                array('escape'=>false,'confirm'=>
                __($confmsg . ' "{0}"?',
                $promotion->title))
           ); ?>
    </li>

    </ul>
</div>
<div class="promotions view large-10 medium-9 columns">
    <div class="small-12 columns">
    <div class="row">
        <div class="large-5 dataTable card border-blue-left columns" style="padding-left:10px">
            <?php if($promotion->cust_group == 0)
                $cgroup = "All";
              else if ($promotion->cust_group == 1)
                $cgroup = "Jewellery";
              else
                $cgroup = "Diamonds";
            ?>
            <p class="subheader"><strong><?= __('Customer Group:') ?></strong> <?= h($cgroup) ?></p>
            <p class="subheader"><strong><?= __('Start Date:') ?></strong> <?= $this->Format->formatDate($promotion->start_date) ?></p>
            <p class="subheader"><strong><?= __('End Date:') ?></strong> <?= $this->Format->formatDate($promotion->end_date) ?></p>
        </div>
      </div>
      <div class="row">


        <div class="large-5 dataTable card border-blue-left columns" style="padding-left:10px;">
            <p class="subheader"><strong><?= __('Test Email Sent') ?></strong></p>
            <p style="display:inline"><?php if (!$promotion->test_mail_sent){
              echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-remove','style'=>'color:#dd5555;font-size:40px']);
            }
            else {
              echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-ok','style'=>'color:#119911;font-size:40px']);
            }?>
            <li class="btn btn-info" style="vertical-align:top;margin-left:10px;margin-top: 5px;">
              <?= $this->Html->link(
              $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-envelope right-pad-5px')).$this->Html->tag('span', __('Send Test Email')),
              ['controller' => 'Promotions', 'action' => 'sendtestemail',$promotion->id,'promotion.json'],array('style'=>'color:white !important','escape'=>false)) ?>
            </li>
          </p>
            <p class="subheader"><strong><?= __('Mail Out Completed') ?></strong></p>
            <p style="display:inline"><?php if (!$promotion->mail_out_completed){
              echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-remove','style'=>'color:#dd5555;font-size:40px']);
            }
            else {
              echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-ok','style'=>'color:#119911;font-size:40px']);
            }?>
            <li class="btn btn-success" style="vertical-align:top;margin-left:10px; margin-top: 5px;">
               <?php echo $this->Form->postLink(
                  $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-send right-pad-5px','style'=>'color:white !important')). __('Send Out Promo Now'),
                       array('action' => 'sendbulkemail', $promotion->id),
                       array('style'=>'color:white !important','escape'=>false,'confirm'=>
                       __('Are you sure you want to bulk mail out promotion "{0}"?',
                       $promotion->title))
                  ); ?>
           </li>
          </p>
        </div>
        <div <?php if(!$promotion->include_sms){ echo ' style="display:none;" '; } ?>
          class="large-6 dataTable card border-blue-left columns" style="padding-left:10px">
          <p class="subheader"><strong><?= __('Test SMS Sent') ?></strong></p>
          <p style="display:inline"><?php if (!$promotion->test_sms_sent){
            echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-remove','style'=>'color:#dd5555;font-size:40px']);
          }
          else {
            echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-ok','style'=>'color:#119911;font-size:40px']);
          }?>
          <li class="btn btn-info" style="vertical-align:top;margin-left:10px;margin-top: 5px;">
            <?= $this->Html->link(
            $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-phone right-pad-5px')).$this->Html->tag('span', __('Send Test SMS')),
            ['controller' => 'Promotions', 'controller'=>'Sms','action' => 'testSms',$promotion->id],array('style'=>'color:white !important','escape'=>false)) ?>
          </li>
          <br /><br /><p><strong>SMS Message Preview</strong></p>
          <p style="border:#ccc 1px dashed;margin-right:10px;padding-left:5px;"><?= $promotion->sms_message ?></p>

        </div>

    </div>
    <div class='row'>
      <h2>Email Preview</h2>

      <!--NB: The following email preview code has all CSS intentionally inline - making it grotesquely difficult to read.
              This is due to the fact that many email clients will strip out <style></style> tags, causing the loss of any
              CSS styling that was contained therein. In order to generate a faithful preview of the email, all inline CSS
              has been maintained almost exactly how it would be received by the email client once sent. Note that there is
              so much CSS as these emails are *fully* responsive for different screen sizes, just like Bootstrap  -->

      <body id="email-prev" style="width: 100% !important; min-width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"><style type="text/css">
    a:hover {
    color: #2795b6 !important;
    }
    a:active {
    color: #2795b6 !important;
    }
    a:visited {
    color: #2ba6cb ;
    }
    h1 a:active {
    color: #2ba6cb !important;
    }
    h2 a:active {
    color: #2ba6cb !important;
    }
    h3 a:active {
    color: #2ba6cb !important;
    }
    h4 a:active {
    color: #2ba6cb !important;
    }
    h5 a:active {
    color: #2ba6cb !important;
    }
    h6 a:active {
    color: #2ba6cb !important;
    }
    h1 a:visited {
    color: #2ba6cb !important;
    }
    h2 a:visited {
    color: #2ba6cb !important;
    }
    h3 a:visited {
    color: #2ba6cb !important;
    }
    h4 a:visited {
    color: #2ba6cb !important;
    }
    h5 a:visited {
    color: #2ba6cb !important;
    }
    h6 a:visited {
    color: #2ba6cb !important;
    }
    table.button:hover td {
    background: #2795b6 !important;
    }
    table.button:visited td {
    background: #2795b6 !important;
    }
    table.button:active td {
    background: #2795b6 !important;
    }
    table.button:hover td a {
    color: #fff !important;
    }
    table.button:visited td a {
    color: #fff !important;
    }
    table.button:active td a {
    color: #fff !important;
    }
    table.button:hover td {
    background: #2795b6 !important;
    }
    table.tiny-button:hover td {
    background: #2795b6 !important;
    }
    table.small-button:hover td {
    background: #2795b6 !important;
    }
    table.medium-button:hover td {
    background: #2795b6 !important;
    }
    table.large-button:hover td {
    background: #2795b6 !important;
    }
    table.button:hover td a {
    color: #ffffff !important;
    }
    table.button:active td a {
    color: #ffffff !important;
    }
    table.button td a:visited {
    color: #ffffff !important;
    }
    table.tiny-button:hover td a {
    color: #ffffff !important;
    }
    table.tiny-button:active td a {
    color: #ffffff !important;
    }
    table.tiny-button td a:visited {
    color: #ffffff !important;
    }
    table.small-button:hover td a {
    color: #ffffff !important;
    }
    table.small-button:active td a {
    color: #ffffff !important;
    }
    table.small-button td a:visited {
    color: #ffffff !important;
    }
    table.medium-button:hover td a {
    color: #ffffff !important;
    }
    table.medium-button:active td a {
    color: #ffffff !important;
    }
    table.medium-button td a:visited {
    color: #ffffff !important;
    }
    table.large-button:hover td a {
    color: #ffffff !important;
    }
    table.large-button:active td a {
    color: #ffffff !important;
    }
    table.large-button td a:visited {
    color: #ffffff !important;
    }
    table.secondary:hover td {
    background: #d0d0d0 !important; color: #555;
    }
    table.secondary:hover td a {
    color: #555 !important;
    }
    table.secondary td a:visited {
    color: #555 !important;
    }
    table.secondary:active td a {
    color: #555 !important;
    }
    table.success:hover td {
    background: #457a1a !important;
    }
    table.alert:hover td {
    background: #970b0e !important;
    }
    table.facebook:hover td {
    background: #2d4473 !important;
    }
    table.twitter:hover td {
    background: #0087bb !important;
    }
    @media only screen and (max-width: 600px) {
      table[class="body"] img {
        width: auto !important; height: auto !important;
      }
      table[class="body"] center {
        min-width: 0 !important;
      }
      table[class="body"] .container {
        width: 95% !important;
      }
      table[class="body"] .row {
        width: 100% !important; display: block !important;
      }
      table[class="body"] .wrapper {
        display: block !important; padding-right: 0 !important;
      }
      table[class="body"] .columns {
        table-layout: fixed !important; float: none !important; width: 100% !important; padding-right: 0px !important; padding-left: 0px !important; display: block !important;
      }
      table[class="body"] .column {
        table-layout: fixed !important; float: none !important; width: 100% !important; padding-right: 0px !important; padding-left: 0px !important; display: block !important;
      }
      table[class="body"] .wrapper.first .columns {
        display: table !important;
      }
      table[class="body"] .wrapper.first .column {
        display: table !important;
      }
      table[class="body"] table.columns td {
        width: 100% !important;
      }
      table[class="body"] table.column td {
        width: 100% !important;
      }
      table[class="body"] .columns td.one {
        width: 8.333333% !important;
      }
      table[class="body"] .column td.one {
        width: 8.333333% !important;
      }
      table[class="body"] .columns td.two {
        width: 16.666666% !important;
      }
      table[class="body"] .column td.two {
        width: 16.666666% !important;
      }
      table[class="body"] .columns td.three {
        width: 25% !important;
      }
      table[class="body"] .column td.three {
        width: 25% !important;
      }
      table[class="body"] .columns td.four {
        width: 33.333333% !important;
      }
      table[class="body"] .column td.four {
        width: 33.333333% !important;
      }
      table[class="body"] .columns td.five {
        width: 41.666666% !important;
      }
      table[class="body"] .column td.five {
        width: 41.666666% !important;
      }
      table[class="body"] .columns td.six {
        width: 50% !important;
      }
      table[class="body"] .column td.six {
        width: 50% !important;
      }
      table[class="body"] .columns td.seven {
        width: 58.333333% !important;
      }
      table[class="body"] .column td.seven {
        width: 58.333333% !important;
      }
      table[class="body"] .columns td.eight {
        width: 66.666666% !important;
      }
      table[class="body"] .column td.eight {
        width: 66.666666% !important;
      }
      table[class="body"] .columns td.nine {
        width: 75% !important;
      }
      table[class="body"] .column td.nine {
        width: 75% !important;
      }
      table[class="body"] .columns td.ten {
        width: 83.333333% !important;
      }
      table[class="body"] .column td.ten {
        width: 83.333333% !important;
      }
      table[class="body"] .columns td.eleven {
        width: 91.666666% !important;
      }
      table[class="body"] .column td.eleven {
        width: 91.666666% !important;
      }
      table[class="body"] .columns td.twelve {
        width: 100% !important;
      }
      table[class="body"] .column td.twelve {
        width: 100% !important;
      }
      table[class="body"] td.offset-by-one {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-two {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-three {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-four {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-five {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-six {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-seven {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-eight {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-nine {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-ten {
        padding-left: 0 !important;
      }
      table[class="body"] td.offset-by-eleven {
        padding-left: 0 !important;
      }
      table[class="body"] table.columns td.expander {
        width: 1px !important;
      }
      table[class="body"] .right-text-pad {
        padding-left: 10px !important;
      }
      table[class="body"] .text-pad-right {
        padding-left: 10px !important;
      }
      table[class="body"] .left-text-pad {
        padding-right: 10px !important;
      }
      table[class="body"] .text-pad-left {
        padding-right: 10px !important;
      }
      table[class="body"] .hide-for-small {
        display: none !important;
      }
      table[class="body"] .show-for-desktop {
        display: none !important;
      }
      table[class="body"] .show-for-small {
        display: inherit !important;
      }
      table[class="body"] .hide-for-desktop {
        display: inherit !important;
      }
      table[class="body"] .right-text-pad {
        padding-left: 10px !important;
      }
      table[class="body"] .left-text-pad {
        padding-right: 10px !important;
      }
    }
    </style>
      <table class="body" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; height: 100%; width: 100%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;background-color:white !important"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="center" align="center" valign="top" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
            <center style="width: 100%; min-width: 580px;">


              <table class="row header" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; background: #0A0A0A; padding: 0px;" bgcolor="#0A0A0A"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="center" align="center" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" valign="top">
                    <center style="width: 100%; min-width: 580px;">

                      <table class="container" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                            <table class="twelve columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="six sub-columns" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; min-width: 0px; width: 50%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 10px 10px 0px;" align="left" valign="top">
                              <?php
                                  echo $this->Html->image('Engage_logo_4col1.png',[
                                   "alt" => "Logo image",
                                   "style" => "outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: auto; max-width: 100%; float: left; clear: both; display: block;"]);

                            ?>
                            </td>

                                <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>

                              </tr></table></td>
                        </tr></table></center>
                  </td>
                </tr></table><br /><table class="container" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top">
                    <!-- content start -->
                    <table class="row" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                          <table class="twelve columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                                <h1 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 40px; margin: 0; padding: 0;" align="left">Hi, Tester</h1>
                                <p class="lead" style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 21px; font-size: 18px; margin: 0 0 10px; padding: 0;" align="left">
                                  <?php
                                  echo "<strong>".$promotion->title."</strong>";
                                  echo "<br />From ".$this->Format->formatDate($promotion->start_date) . " until " . $this->Format->formatDate($promotion->end_date);
                                ?>
                              </p>
                                <table class="twelve columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">
                                  <?php if (!empty($promotion->promo_image) && $promotion->promo_image != null){
                                  echo $this->Html->image('../'.$promotion->promo_image, [
                                       "alt" => "Promotional image",
                                       "style" => "height:300px !important;outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;  max-width: 100%; float: left; clear: both; display: block;"]);
                                }
                                ?>
                              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                            </tr></table></td>
                      </tr></table><table class="row callout" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                          <table class="twelve columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="panel" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ECF8FF; margin: 0; padding: 10px; border: 1px solid #b9e5ff;" align="left" bgcolor="#ECF8FF" valign="top">
                              <?php
                                  $shortwebsite = $settings->website;
                                  if (substr($settings->website,0,4) != "http")
                                    $settings->website = "http://" . $settings->website;
                                  echo "
                                  <h3 style=\"color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 25px !important; font-size: 20px !important; margin: 0 0 10px; padding: 0;\" align=\"left\">$promotion->headline</h3>
                                  <p style=\"color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;\" align=\"left\">$promotion->description <br />Please come in directly to our retail store or purchase jewellery online via our website <a href=\"" . $settings->website . "\" style=\"color: #2ba6cb; text-decoration: none;\">";
                                  echo $shortwebsite ."</a>
                                    where you can browse our complete range and find the perfect piece for any occasion.</p>
                                  ";

                                ?>
                              </td>
                              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                            </tr></table></td>
                      </tr></table><table class="row" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                          <table class="twelve columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                                <h4 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 28px; margin: 0; padding: 0;" align="left">Engage Jewellery</h4>
                                <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">We aim to make Engage Jewellery your first-choice destination for high-quality fine jewellery online.
                                  <?= $promotion->aboutengage ?></p>

                              </td>
                              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                            </tr></table></td>
                      </tr></table><table class="row" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                          <table class="three columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 130px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                                <table class="button" style="padding-left:10px !important;border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: none !important; margin: 0; padding: 8px 0; border: 1px solid #2284a1;" align="center" bgcolor="#2ba6cb" valign="top">
                                      <a href="http://www.engagejewellery.com.au" style="border-color:transparent !important;color: #ffffff !important; text-decoration: none; font-weight: bold; font-family: Helvetica, Arial, sans-serif; font-size: 16px;">Visit us online</a>
                                    </td>
                                  </tr></table></td>
                              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                            </tr></table></td>
                      </tr></table><table class="row footer" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ebebeb; margin: 0; padding: 10px 20px 0px 0px;" align="left" bgcolor="#ebebeb" valign="top">

                          <table class="six columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 280px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="left-text-pad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px 10px;" align="left" valign="top">

                                <h5 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 24px; margin: 0; padding: 0 0 10px;" align="left">Connect With Us</h5>

                                <table class="tiny-button facebook" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #3b5998; margin: 0; padding: 5px 0 4px; border: 1px solid #2d4473;" align="center" bgcolor="#3b5998" valign="top">
                                      <a href="https://www.facebook.com/engage.jewellery" style="color: #ffffff !important; text-decoration: none; font-weight: normal; font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Facebook</a>
                                    </td>
                                  </tr></table><br /><table class="tiny-button twitter" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #00acee; margin: 0; padding: 5px 0 4px; border: 1px solid #0087bb;" align="center" bgcolor="#00acee" valign="top">
                                      <a href="https://twitter.com/engagejewellery" style="color: #ffffff  !important; text-decoration: none; font-weight: normal; font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Twitter</a>
                                    </td>
                                  </tr></table><br /></td>
                              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                            </tr></table></td>
                        <td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ebebeb; margin: 0; padding: 10px 0px 0px;" align="left" bgcolor="#ebebeb" valign="top">

                          <table class="six columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 280px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="last right-text-pad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">
                                <h5 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 24px; margin: 0; padding: 0 0 10px;" align="left">Contact Info</h5>
                                <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Phone: <?= $settings->phone ?></p>
                                <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Email: <a href="mailto:<?= $settings->admin_email ?>" style="color: #2ba6cb; text-decoration: none;"><?= $settings->admin_email ?></a></p>
                              </td>
                              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                            </tr></table></td>
                      </tr></table><table class="row" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                          <table class="twelve columns" style="border-color:transparent;border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td align="center" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" valign="top">
                                <center style="width: 100%; min-width: 580px;">
                                  <p style="text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="center">
                                    <?= $this->Html->link(__('Unsubscribe'),
                                       ['controller'=>'customers','action' => 'unsubscribe',$id,'email'=>$email],['style'=>'color: #2ba6cb; text-decoration: none;']);
                                    ?>
                                  </p>
                                </center>
                              </td>
                              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                            </tr></table></td>
                      </tr></table><!-- container end below --></td>
                </tr></table></center>
          </td>
        </tr></table></body>

    </div>
  </div>
</div>
