<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class SmsComponent extends Component {

  public function sendSingleSms($settingsmodel,$custmodel,$ordermodel,$custid,$orderid,$message){
      $settings = $settingsmodel->get(1);
      $customer = $custmodel->get($custid);
      $order = $ordermodel->get($orderid);

      $username = $settings->sms_username;
      $password = $settings->sms_password;

      //$destination = '0400000000'; //Multiple numbers can be entered, separated by a comma
      $destination = $customer->phone;

      $source    = 'Engage';
      $text = $message;
      $ref = 'smsengage';

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
            $msgresp = "The message to ".$message_data[1]." was successful!";
          }elseif( $message_data[0] == "BAD" ){
            $msgresp = "The message to ".$message_data[1]." was NOT successful. Reason: ".$message_data[2];
          }elseif( $message_data[0] == "ERROR" ){
            $msgresp = "There was an error with this request. Reason: ".$message_data[1];
          }

          return $msgresp;
      }
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
}

?>
