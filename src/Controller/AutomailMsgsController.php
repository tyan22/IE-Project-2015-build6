<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AutomailMsgs Controller
 *
 * @property \App\Model\Table\AutomailMsgsTable $AutomailMsgs
 */
class AutomailMsgsController extends AppController
{

    /**
     * Edit method
     *
     * @param string|null $id Automail Msg id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        if (isset($this->request->query['type']) && $this->request->query['type'] == 'zodiac')
          $msgs = $this->AutomailMsgs->find()->where(['type'=>'zodiac']);
        else
          $msgs = $this->AutomailMsgs->find()->where(['type'=>'month']);

        if ($this->request->is(['post', 'put'])) {
            //TODO: foreach loop here to save each message.
            if ($this->AutomailMsgs->save($automailMsg)) {
                $this->Flash->success(__('The default messages have been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The default messages could not be saved. Please try again.'));
            }
        }
        $this->set('msgs', $msgs);
    }

}
