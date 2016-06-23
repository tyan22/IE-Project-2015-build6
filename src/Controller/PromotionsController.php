<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Routing\Router;


/**
 * Promotions Controller
 *
 * @property \App\Model\Table\PromotionsTable $Promotions
 */
class PromotionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('promotions', $this->paginate($this->Promotions));
        $this->set('_serialize', ['promotions']);
    }

    /**
     * View method
     *
     * @param string|null $id Promotion id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function mailout($id = null)
    {
        $promotion = $this->Promotions->get($id, [
            'contain' => []
        ]);
        $this->loadModel('Settings');
        $settings = $this->Settings->get(1);
        $baseurl = Router::url('/', true);
        $this->set('baseurl',$baseurl);
        $this->set('promotion', $promotion);
        $this->set('settings',$settings);
        $this->set('id','100');
        $this->set('email','test@test.com');
        $this->set('_serialize', ['promotion']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $promotion = $this->Promotions->newEntity();
        if ($this->request->is(['post','put'])) {
            $promotion = $this->Promotions->patchEntity($promotion, $this->request->data);
            if (!empty($this->request->data['sms_message']) && $this->request->data['sms_message'] != null)
              $promotion->include_sms = true;
            else
              $promotion->include_sms = false;
            $starttime = Time::createFromFormat('d-m-Y',$this->request->data['start']);
            $endtime = Time::createFromFormat('d-m-Y',$this->request->data['end']);
            $promotion->start_date = $starttime;
            $promotion->end_date = $endtime;

            if ($this->Promotions->save($promotion)) {
                if ($this->request->data['promo_image']['error'] != 4){
                    echo "<h1>promotion-with img</h1>";

                    //upload image if user has selected one
                    //calls uploadFiles function in AppController.php
                    $uploadStatus = $this->uploadImageFile('promoimages', $this->request->data['promo_image'],$promotion->id);
                    print_r($uploadStatus);
                    //if $uploadStatus array contains filepath key, we had success uploading file
                    if (array_key_exists('filepath', $uploadStatus)) {
                        $promotion->promo_image = $uploadStatus['filepath'][0];
                        if ($this->Promotions->save($promotion))
                          $this->Flash->success(__('The promotion has been saved.'));
                    }
                    else {
                       $this->Flash->error(__('The promotion has been saved but the image was invalid.'));
                    }
                }
                else {
                  $this->Flash->success(__('The promotion has been saved.'));
                }
                return $this->redirect(['controller'=>'Promotions','action' => 'mailout',$promotion->id]);
           }
           else {
             $this->Flash->error(__('The promotion could not be saved. Please, try again.'));
           }
        }

       $this->set(compact('promotion'));
       $this->set('_serialize', ['promotion']);
  }

    /**
     * Edit method
     *
     * @param string|null $id Promotion id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $promotion = $this->Promotions->get($id, [
            'contain' => []
        ]);
        $old_img = $promotion->promo_image;

      if ($this->request->is(['post', 'patch','put'])){

            $promotion = $this->Promotions->patchEntity($promotion, $this->request->data);
            if (!empty($this->request->data['sms_message']) && $this->request->data['sms_message'] != null)
              $promotion->include_sms = true;
            else
              $promotion->include_sms = false;
            $starttime = Time::createFromFormat('d-m-Y',$this->request->data['start']);
            $endtime = Time::createFromFormat('d-m-Y',$this->request->data['end']);
            $promotion->start_date = $starttime;
            $promotion->end_date = $endtime;
            if ($this->request->data['promo_image']['error'] != 4){

              //upload image if user has selected one
              //calls uploadFiles function in AppController.php
              $uploadStatus = $this->uploadImageFile('promoimages', $this->request->data['promo_image'],$promotion->id);
              //if $uploadStatus array contains filepath key, we had success uploading file
              if (array_key_exists('filepath', $uploadStatus)) {
                if(!empty($old_img) && $old_img != null)
                {
                   $filePath = WWW_ROOT.$old_img;

                   if (file_exists($filePath))
                       unlink($filePath);

                }
                  $promotion->promo_image = $uploadStatus['filepath'][0];

                  if ($this->Promotions->save($promotion)) {
                     $this->Flash->success(__('The promotion has been saved.'));

                     return $this->redirect(['controller'=>'Promotions','action' => 'mailout',$promotion->id]);
                  }
                  else {
                    $this->Flash->error(__('The promotion could not be saved. Please, try again.'));
                  }
             }
             else {
                 $this->Flash->error(__('The promotion could not be saved. Please, try again.'));
             }
           }

           else {
             if (!empty($old_img) && $old_img != null){
               if ($this->request->data['remove_image'] == 1)
               {
                  $promotion->promo_image = null;
               }
               else
                 $promotion->promo_image = $old_img;
             }
             else {
               $promotion->promo_image = null;
             }

             echo "<h1>$promotion->promo_image</h1>";
             if ($this->Promotions->save($promotion)) {
                $this->Flash->success(__('The promotion has been saved.'));
                return $this->redirect(['controller'=>'Promotions','action' => 'mailout',$promotion->id]);
             }
             else {
               $this->Flash->error(__('The promotion could not be saved. Please, try again.'));
             }
           }
         }
        $this->set(compact('promotion'));
        $this->set('_serialize', ['promotion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Promotion id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $promotion = $this->Promotions->get($id);
        $image_to_delete = $promotion->promo_image;
        $folder_to_delete = WWW_ROOT.'promoimages/'.$promotion->id;
        if ($this->Promotions->delete($promotion)) {
          if(!empty($image_to_delete) && $image_to_delete != null)
          {
              $filePath = WWW_ROOT.$image_to_delete;

              if (file_exists($filePath))
                  unlink($filePath);

              rmdir($folder_to_delete);

           }
            $this->Flash->success(__('The promotion has been deleted.'));
        } else {
            $this->Flash->error(__('The promotion could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function sendtestemail($id = null)
    {
      $baseurl = Router::url('/', true);
      $promotion = $this->Promotions->get($id);
      $this->loadModel('Settings');
      $settings = $this->Settings->get(1);
          $email = new Email();
          $email->template('promos', 'engage') //view, layout
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
                      'promoid' => $promotion->id,
                      'promoimg' => $promotion->promo_image,
                      'title' => $promotion->title,
                      'headline'=>$promotion->headline,
                      'description'=>$promotion->description,
                      'aboutengage'=>$promotion->aboutengage,
                      'start_date'=>$promotion->start_date,
                      'end_date'=>$promotion->end_date])
          ->from('noreply@orders.engagejewellery.com.au')
          ->subject($promotion->title)
          ->helpers(['Html','Format']);
          try {
            $email->send();
            $promotion = $this->Promotions->get($id);
            $promotion->test_mail_sent = true;
            $this->Promotions->save($promotion);
            $this->Flash->success(__('Test email sent'));
          }
          catch (Exception $e){
            $this->Flash->error(__('Test email failed to send!'));
        }


      $this->set('promotion',$promotion);
      $this->set('_serialize',array('promotion'));

      return $this->redirect(['action' => 'mailout',$promotion->id]);

    }

    public function sendbulkemail($id = null)
    {
      $baseurl = Router::url('/', true);

      $this->loadModel('Settings');
      $settings = $this->Settings->get(1);
      $promotion = $this->Promotions->get($id);
      $this->loadModel('Customers');
      if ($promotion->cust_group == "All")
         $custs = $this->Customers->find()->where(['mailing_list'=>true,'email IS NOT'=>'null']);
      else if ($promotion->cust_group == "Diamonds")
         $custs = $this->Customers->find()->where(['mailing_list'=>true,'cust_type'=>'Diamond','email IS NOT'=>'null']);
      else if ($promotion->cust_group == "Jewellery")
         $custs = $this->Customers->find()->where(['mailing_list'=>true,'cust_type'=>'Jewellery','email IS NOT'=>'null']);
          //iterate through and send all emails
          foreach ($custs as $cust)
          {
            if (!empty($cust->email) && $cust->email != null)
            {
              $email = new Email();
              $email->template('promos', 'engage') //view, layout
              ->emailFormat('html')
              ->to($cust->email)
              ->transport('default')
              ->viewVars(['firstname' => $cust->firstname,
                      'id' => $cust->id,
                      'email' => $cust->email,
                      'adminemail' => $settings->admin_email,
                      'website' => $settings->website,
                      'phone' => $settings->phone,
                      'baseurl' => $baseurl,
                      'promoid' => $promotion->id,
                      'promoimg' => $promotion->promo_image,
                      'title' => $promotion->title,
                      'headline'=>$promotion->headline,
                      'description'=>$promotion->description,
                      'aboutengage'=>$promotion->aboutengage,
                      'start_date'=>$promotion->start_date,
                      'end_date'=>$promotion->end_date])
            ->from('noreply@orders.engagejewellery.com.au')
            ->subject($promotion->title)
            ->helpers(['Html'])
            ->send();
          }
         }

         $promotion = $this->Promotions->get($id);
         $promotion->mail_out_completed = true;
         $this->Promotions->save($promotion);
         $this->Flash->success(__('Bulk email mailout sent'));

      $this->set('customers',$custs);
      $this->set('_serialize',array('customers'));

      if (!empty($promotion->sms_message) && $promotion->sms_message != null)
        return $this->redirect(['controller'=>'Sms','action' => 'sendPromoSms',$promotion->id]);
      else
        return $this->redirect(['controller'=>'Promotions','action' => 'mailout',$promotion->id]);

    }

}
