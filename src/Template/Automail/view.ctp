<?php
    $this->assign('title', "View Automatic Mailout");
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
      <?php
      if ($automail->id == 1) {
        echo "<li>" . $this->Html->link(
        $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-edit right-pad-5px')).$this->Html->tag('span', __('Edit Zodiac Messages')),
        ['controller'=>'automail_msgs','action' => 'edit','type'=>'zodiac'],
        array('escape'=>false)) .
       "</li>";
     }
     else if ($automail->id == 2){
       echo "<li>" . $this->Html->link(
       $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-edit right-pad-5px')).$this->Html->tag('span', __('Edit Month Messages')),
       ['controller'=>'automail_msgs','action' => 'edit','type'=>'monthly'],
       array('escape'=>false)) .
      "</li>";
     }
       ?>
      <li><?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit This Auto Mail')),
         ['controller' => 'Automail', 'action' => 'edit',$automail->id],
         array('escape'=>false)) ?>
      </li>
     <li>
       <?= $this->Html->link(
       $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-envelope right-pad-5px')).$this->Html->tag('span', __('Send Test Email')),
       ['controller' => 'Automail', 'action' => 'sendtestemail',$automail->id,'automail.json'],array('escape'=>false)) ?>
     </li>
    </ul>
</div>

<div class="promotions view large-10 medium-9 columns">
  <h2><strong><?php if ($automail->id == 1){
     echo __('View Zodiac Auto Mailout');
     $this->assign('title', "View Zodiac Auto Mailout");
     $this->Html->addCrumb('View Zodiac Auto Mailout', ['controller' => 'automail', 'action' => 'view',$automail->id]);
   }
  else if ($automail->id == 2){
     echo __('View Birthday Auto Mailout');
     $this->assign('title', "View Birthday Auto Mailout");
     $this->Html->addCrumb('View Birthday Auto Mailout', ['controller' => 'automail', 'action' => 'view',$automail->id]);
   }
  else if ($automail->id == 3){
     echo __('View Anniv. Auto Mailout');
     $this->assign('title', "View Anniv. Auto Mailout");
     $this->Html->addCrumb('View Anniv. Auto Mailout', ['controller' => 'automail', 'action' => 'view',$automail->id]);
   } ?></strong></h2>
    <div class="small-12 columns">
    <div class="row">
        <div class="large-5 dataTable card border-blue-left" style="padding-left:10px">
          <br />
            <li class="btn btn-info" style="vertical-align:top;margin-left:10px;margin-top: 5px;">
              <?= $this->Html->link(
              $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-envelope right-pad-5px')).$this->Html->tag('span', __('Send Test Email')),
              ['controller' => 'Automail', 'action' => 'sendtestemail',$automail->id,'automail.json'],array('style'=>'color:white !important','escape'=>false)) ?>
            </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <p style="display:inline"><?php if (!$automail->active){
              echo $this->Html->tag('i', '<span style="font-size:15px;font-weight:bold;vertical-align:13px;">INACTIVE</span>', ['class' => 'glyphicon glyphicon-remove','style'=>'color:#dd5555;font-size:40px']);
            }
            else {
              echo $this->Html->tag('i', 'ACTIVE', ['class' => 'glyphicon glyphicon-ok','style'=>'color:#119911;font-size:40px']);
            }?>
          </p><br /><br />
        </div>
    </div>
    <div class='row'>
      <h2>Email Preview</h2>
      <?php
      		if (!isset($annivtype) || empty($annivtype))
      			$annivtype="";
      		if (!isset($birthstone) || empty($birthstone))
      				$birthstone="";
      	  if (!isset($starsign) || empty($starsign))
      			 $starsign="";
      	?>
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
      	<table class="body" style="background-color:white; border-spacing: 0;  border-collapse: collapse; vertical-align: top; text-align: left; height: 100%; width: 100%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="center" align="center" valign="top" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;">
              <center style="width: 100%; min-width: 580px;">


                <table class="row header" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; background: #0A0A0A; padding: 0px;" bgcolor="#0A0A0A"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="center" align="center" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" valign="top">
                      <center style="width: 100%; min-width: 580px;">

                        <table class="container" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                              <table class="twelve columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="six sub-columns" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; min-width: 0px; width: 50%; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 10px 10px 0px;" align="left" valign="top">
                                    <img src="../../img/Engage_logo_4col1.png" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: auto; max-width: 100%; float: left; clear: both; display: block;" align="left" /></td>

                                  <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>

                                </tr></table></td>
                          </tr></table></center>
                    </td>
                  </tr></table><br /><table class="container" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top">

                      <!-- content start -->
                      <table class="row" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                            <table class="twelve columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                                  <h1 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 40px; margin: 0; padding: 0;" align="left">Hi, Tester</h1>

                                  <p class="lead" style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 21px; font-size: 18px; margin: 0 0 10px; padding: 0;" align="left">

                                    <?= $automail->headline ?>

                                </p><br />
      													<table class="twelve columns" style="border-spacing: 0; border-color: transparent; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">
      														 <?php if ($automail->image != "NULL" && !empty($automail->image) && $automail->image != null)
      															echo "<img src='../../$automail->image' style='height:350px !important;outline: none;
      															text-decoration: none; -ms-interpolation-mode: bicubic; width: auto;
      															max-width: 100%; float: left; clear: both; display: block;' align='left'/>";
      														?>
      															</td></tr></table></td>
                                <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                              </tr></table></td>
                        </tr></table><table class="row callout" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                            <table class="twelve columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="panel" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ECF8FF; margin: 0; padding: 10px; border: 1px solid #b9e5ff;" align="left" bgcolor="#ECF8FF" valign="top">
      													<?php

      													$shortwebsite = $settings->website;
      													if (substr($settings->website,0,4) != "http")
      														$settings->website = "http://" . $settings->website;
      													echo '<p>'.$automail->description.'</p>';
      													if ($this->request->pass[0] == "2"){
                                  echo "
                                  <p style=\"color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;\" align=\"left\">Please come in directly to our retail store or purchase jewellery online via our website <a href=\"" . $settings->website . "\" style=\"color: #2ba6cb; text-decoration: none;\">" . $shortwebsite . "</a>
      															where you browse our complete range and find a truly personal piece just for you.</p>";
      														}
      														else if ($this->request->pass[0] == "3"){
      															echo "
                                    <p style=\"color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;\" align=\"left\">Please come in directly to our retail store or purchase jewellery online via our website <a href=\"" . $settings->website . "\" style=\"color: #2ba6cb; text-decoration: none;\">" . $shortwebsite . "</a>
      																where you browse our complete range and find a truly personal piece just for that special anniversary.</p>";
      														}
      														else if ($this->request->pass[0] == "1")
      														{
      															echo "
      															<p style=\"color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;\" align=\"left\">Please come in directly to our retail store or purchase jewellery online via our website <a href=\"" . $settings->website . "\" style=\"color: #2ba6cb; text-decoration: none;\">" . $shortwebsite . "</a>
      																where you browse our complete range.</p>";
      														}
      														?>
                                </td>
                                <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                              </tr></table></td>
                        </tr></table><table class="row" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                            <table class="twelve columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                                  <h4 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 28px; margin: 0; padding: 0;" align="left">Engage Jewellery</h4>
                                  <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">
      															<?= $automail->aboutengage ?></p>

                                </td>
                                <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                              </tr></table></td>
                        </tr></table><table class="row" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                            <table class="three columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 130px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                                  <table class="button" style="background-color:transparent !important;border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #2ba6cb; margin: 0; padding: 8px 0; border: 1px solid #2284a1;" align="center" bgcolor="#2ba6cb" valign="top">
                                        <a href="<?= $settings->website ?>" style="padding-left:5px !important;padding-right:5px !important;color: #ffffff; text-decoration: none; font-weight: bold; font-family: Helvetica, Arial, sans-serif; font-size: 16px;">Visit us online</a>
                                      </td>
                                    </tr></table></td>
                                <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                              </tr></table></td>
                        </tr></table><table class="row footer" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ebebeb; margin: 0; padding: 10px 20px 0px 0px;" align="left" bgcolor="#ebebeb" valign="top">

                            <table class="six columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 280px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="left-text-pad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px 10px;" align="left" valign="top">

                                  <h5 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 24px; margin: 0; padding: 0 0 10px;" align="left">Connect With Us</h5>

                                  <table class="tiny-button facebook" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #3b5998; margin: 0; padding: 5px 0 4px; border: 1px solid #2d4473;" align="center" bgcolor="#3b5998" valign="top">
                                        <a href="https://www.facebook.com/engage.jewellery" style="color: #ffffff; text-decoration: none; font-weight: normal; font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Facebook</a>
                                      </td>
                                    </tr></table><br /><table class="tiny-button twitter" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; overflow: hidden; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: center; color: #ffffff; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; display: block; width: auto !important; background: #00acee; margin: 0; padding: 5px 0 4px; border: 1px solid #0087bb;" align="center" bgcolor="#00acee" valign="top">
                                        <a href="https://twitter.com/engagejewellery" style="color: #ffffff; text-decoration: none; font-weight: normal; font-family: Helvetica, Arial, sans-serif; font-size: 12px;">Twitter</a>
                                      </td>
                                    </tr></table><br /></td>
                                <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                              </tr></table></td>
                          <td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ebebeb; margin: 0; padding: 10px 0px 0px;" align="left" bgcolor="#ebebeb" valign="top">

                            <table class="six columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 280px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="last right-text-pad" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">
                                  <h5 style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 24px; margin: 0; padding: 0 0 10px;" align="left">Contact Info</h5>
                                  <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Phone: <?= $settings->phone ?></p>
                                  <p style="color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Email: <a href="mailto:<?= $settings->admin_email ?>" style="color: #2ba6cb; text-decoration: none;"><?= $settings->admin_email ?></a></p>
                                </td>
                                <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
                              </tr></table></td>
                        </tr></table><table class="row" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

                            <table class="twelve columns" style="border-spacing: 0; border-color: transparent; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td align="center" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" valign="top">
                                  <center style="width: 100%; min-width: 580px;">
                                    <p style="text-align: center; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="center">
      																<?= $this->Html->link(__('Unsubscribe'),
      																	 ['controller'=>'customers','action' => 'unsubscribe',1,'email'=>'test@test.com'],['style'=>'color: #2ba6cb; text-decoration: none;']);
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
