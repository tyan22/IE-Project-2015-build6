<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class SmsController extends AppController
{
    public $components = array('RequestHandler');

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['sendSMS']);
    }


    private function sendSMS($content) {
        $ch = curl_init('https://api.smsbroadcast.com.au/api-adv.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);
        curl_close ($ch);
        return $output;
    }

    public function testSms($id){


          $this->loadModel('Settings');
          $settings = $this->Settings->get(1);

          $this->loadModel('Promotions');
          $promotion = $this->Promotions->get($id);

          $username = $settings->sms_username;
          $password = $settings->sms_password;
          //$destination = '0400000000'; //Multiple numbers can be entered, separated by a comma
          $destination = $settings->sms_test_mobile;
          $source    = 'Engage';
          //$text = 'This is our test message.';
          $text = $promotion->sms_message;
          $ref = 'testsms';

          $content =  'username='.rawurlencode($username).
                '&password='.rawurlencode($password).
                '&to='.rawurlencode($destination).
                '&from='.rawurlencode($source).
                '&message='.rawurlencode($text).
                '&ref='.rawurlencode($ref);

            $smsbroadcast_response = $this->sendSMS($content);
            $response_lines = explode("\n", $smsbroadcast_response);

            foreach( $response_lines as $data_line){
              $message_data = "";
              $message_data = explode(':',$data_line);
              if($message_data[0] == "OK"){
                $this->Flash->success("The message to ".$message_data[1]." was successful!");
                $promotion->test_sms_sent = true;
                $this->Promotions->save($promotion);
              }elseif( $message_data[0] == "BAD" ){
                $this->Flash->error("The message to ".$message_data[1]." was NOT successful. Reason: ".$message_data[2]);
              }elseif( $message_data[0] == "ERROR" ){
                $this->Flash->error("There was an error with this request. Reason: ".$message_data[1]);
              }
          }

          return $this->redirect(['controller'=>'Promotions','action' => 'mailout',$promotion->id]);
    }

    public function sendPromoSms($id){

          $this->loadModel('Settings');
          $settings = $this->Settings->get(1);

          $this->loadModel('Promotions');
          $promotion = $this->Promotions->get($id);

          $this->loadModel('Customers');
          if ($promotion->cust_group == "All")
             $custs = $this->Customers->find()->where(['mailing_list'=>true,'phone LIKE'=>'04%']);
          else if ($promotion->cust_group == "Diamonds")
             $custs = $this->Customers->find()->where(['mailing_list'=>true,'cust_type'=>'Diamond','phone LIKE'=>'04%']);
          else if ($promotion->cust_group == "Jewellery")
             $custs = $this->Customers->find()->where(['mailing_list'=>true,'cust_type'=>'Jewellery','phone LIKE'=>'04%']);

          $username = $settings->sms_username;
          $password = $settings->sms_password;

          $source    = 'Engage';

          $text = $promotion->sms_message;
          $ref = 'testsms';

          $counter = 0;
          //iterate through and send all emails
          foreach ($custs as $cust)
          {

          $content =  'username='.rawurlencode($username).
                '&password='.rawurlencode($password).
                '&to='.rawurlencode($cust->phone).
                '&from='.rawurlencode($source).
                '&message='.rawurlencode($text).
                '&ref='.rawurlencode($ref);

            $smsbroadcast_response = $this->sendSMS($content);
            $response_lines = explode("\n", $smsbroadcast_response);

            foreach( $response_lines as $data_line){
              $message_data = "";
              $message_data = explode(':',$data_line);
              if($message_data[0] == "OK"){
                $counter++;
              }
          }

        }
          if ($counter > 0)
             $this->Flash->success('All emails sent correctly and ' . $counter . " SMSs were successfully sent!");
          else
            $this->Flash->error("All emails sent correctly but the SMSs failed to send! Check your account details and account credit.");

          return $this->redirect(['controller'=>'Promotions','action' => 'mailout',$promotion->id]);
    }
  }

?>
