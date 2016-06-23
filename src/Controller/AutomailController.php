<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
/**
 * Automail Controller
 *
 * @property \App\Model\Table\AutomailTable $Automail
 */
class AutomailController extends AppController
{

    /**
     * View method
     *
     * @param string|null $id Automail id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $automail = $this->Automail->get($id, [
            'contain' => []
        ]);

        $zodiacNow = $this->getZodiac();
        $this->loadModel('Zodiacbirthstones');
        $starsign = $this->Zodiacbirthstones->find()->where(['id' => $zodiacNow])->extract('sign')->first();

        $this->loadModel('Settings');
        $settings = $this->Settings->get(1);


        $now = Time::now();
        $monthid = $now->month;
        $msg_txt = "";

        $this->loadModel('AutomailMsgs');

        $type = "";
        if ($id == 1){
          $type = "zodiac";
          $msg = $this->AutomailMsgs->find()->where(['id'=>($zodiacNow + 12)])->first();
          $msg_txt = $msg->msg;
        }
        else if ($id == 2){
          $type = "bday";
          $msg = $this->AutomailMsgs->find()->where(['id'=>$monthid])->first();
          $msg_txt = $msg->msg;
        }
        else
        {
          $type = "anniv";
          $msg_txt = "There's a very special day coming up! Make your " . strtolower("test anniversary type") . " a perfect one with a gift from Engage Jewellery.";
        }

        $automail->description = $msg_txt;

        $this->set('starsign',$starsign);
        $this->set('settings',$settings);
        $this->set('automail', $automail);
        $this->set('_serialize', ['automail']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Automail id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $automail = $this->Automail->get($id, [
            'contain' => []
        ]);

        $this->loadModel('AutomailMsgs');

        $zodiacNow = $this->getZodiac();
        $now = Time::now();
        $monthid = $now->month;
        $msg_txt = "";

      $type = "";
      if ($id == 1){
        $type = "zodiac";
        $msg = $this->AutomailMsgs->find()
          ->where(['id'=>($zodiacNow + 12)])->first();
        $msg_txt = $msg->msg;
      }
      else if ($id == 2){
        $type = "bday";
        $msg = $this->AutomailMsgs->find()
          ->where(['id'=>$monthid])->first();
        $msg_txt = $msg->msg;
      }
      else
      {
        $type = "anniv";
        $msg_txt = "There's a very special day coming up! Make your " . strtolower("test anniversary type") . " a perfect one with a gift from Engage Jewellery.";
      }

        $old_img = $automail->image;
        $automail->description = $msg_txt;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $automail = $this->Automail->patchEntity($automail, $this->request->data);
            $automail->description = $msg_txt;
            if ($this->request->data['image']['error'] != 4){
                            //upload image if user has selected one
                            //calls uploadFiles function in AppController.php
                            $uploadStatus = $this->uploadImageFile('automailimages', $this->request->data['image'],$automail->id);
                            //if $uploadStatus array contains filepath key, we had success uploading file
                            if (array_key_exists('filepath', $uploadStatus)) {
                              if(!empty($old_img) && $old_img != null)
                              {
                                 $filePath = WWW_ROOT.$old_img;

                                 if (file_exists($filePath))
                                     unlink($filePath);

                              }
                                $automail->image = $uploadStatus['filepath'][0];

                                if ($this->Automail->save($automail)) {
                                   $this->Flash->success(__('The automatic mailout has been updated.'));

                                   return $this->redirect(['controller'=>'automail','action' => 'view',$automail->id]);
                                }
                                else {
                                  $this->Flash->error(__('The automatic mailout could not be updated. Please, try again.'));
                                }
                           }
                           else {
                               $this->Flash->error(__('The automatic mailout could not be updated. Please, try again.'));
                           }
                         }
                         else {
                           if (!empty($old_img) && $old_img != null){
                             if ($this->request->data['remove_image'] == 1)
                             {
                                $automail->image = null;
                             }
                             else
                               $automail->image = $old_img;
                           }
                           else {
                             $automail->image = null;
                           }

                           echo $automail->image;
                           if ($this->Automail->save($automail)) {
                              $this->Flash->success(__('The automatic mailout has been updated.'));
                              return $this->redirect(['controller'=>'Automail','action' => 'view',$automail->id]);
                           }
                           else {
                             $this->Flash->error(__('The automatic mailout could not be updated. Please, try again.'));
                           }
                         }

        }

        $this->loadModel('Zodiacbirthstones');
        $starsign = $this->Zodiacbirthstones->find()->where(['id' => $zodiacNow])->extract('sign')->first();

        $this->set('starsign',$starsign);
        $this->set(compact('automail'));
        $this->set('_serialize', ['automail']);
    }

    public function sendtestemail($id = null)
    {
      $baseurl = Router::url('/', true);
      $automail = $this->Automail->get($id);

      $this->loadModel('Settings');
      $settings = $this->Settings->get(1);

      $zodiacNow = $this->getZodiac();
      $now = Time::now();
      $monthid = $now->month;
      $msg_txt = "";

      $this->loadModel('AutomailMsgs');

      $type = "";
      if ($id == 1){
        $type = "zodiac";
        $msg = $this->AutomailMsgs->find()
          ->where(['id'=>($zodiacNow + 12)])->first();
        $msg_txt = $msg->msg;
      }
      else if ($id == 2){
        $type = "bday";
        $msg = $this->AutomailMsgs->find()
          ->where(['id'=>$monthid])->first();
        $msg_txt = $msg->msg;
      }
      else
      {
        $type = "anniv";
        $msg_txt = "There's a very special day coming up! Make your " . strtolower("test anniversary type") . " a perfect one with a gift from Engage Jewellery.";
      }

          $email = new Email();
          $email->template('annivs', 'engage') //view, layout
          ->emailFormat('html')
          ->to('admin@orders.engagejewellery.com.au')
          ->transport('default')
          ->viewVars(['firstname' => 'Tester',
                      'id' => '100',
                      'email' => 'test@test.com',
                      'adminemail' => $settings->admin_email,
                      'website' => $settings->website,
                      'phone' => $settings->phone,
                      'baseurl' => $baseurl,
                      'type' => $automail->cust_group,
                      'promoid' => $automail->id,
                      'promoimg' => $automail->image,
                      'title' => $automail->title,
                      'headline'=>$automail->headline,
                      'description'=>$msg_txt,
                      'aboutengage'=>$automail->aboutengage
                      ])
          ->from('noreply@orders.engagejewellery.com.au')
          ->subject($automail->title)
          ->helpers(['Html','Format']);
          try {
            $email->send();
            $this->Flash->success(__('Test email sent'));
          }
          catch (Exception $e){
            $this->Flash->error(__('Test email failed to send!'));
        }


      $this->set('automail',$automail);
      $this->set('_serialize',array('automail'));

      return $this->redirect(['action' => 'view',$automail->id]);

    }

}
