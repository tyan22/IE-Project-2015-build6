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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;



/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {

       $this->loadComponent('RequestHandler');


        //load component to display flash messages
        $this->loadComponent('Flash');
        //load authentication component

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            //redirect to home page if user is not coming from another page in the site
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'display',
                'start'
            ],
            //redirect user to home page if logged out
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ]
        ]);


    }

    public function beforeFilter(Event $event)
    {
        //allow all users to access display and index views
        //cannot stick add in here as it will also apply to groups, which we dont want...
        $this->Auth->allow(['index','display','forgot','view','unsubscribe']);

    }

    public function isAuthorized($user)
    {
        // Admin (group_id 1) can access every action
        if (isset($user['group_id']) && $user['group_id'] == '1') {
            return true;
        }

        // Default deny
        return false;
    }
    /*
    ** The following function was adapted from http://ie.infotech.monash.edu.au/Buckemoff/files/view/Horses,
    ** accessed on 17/5/2015
    */
    public function uploadFiles($folder, $formdata, $orderId)
    {
        // setup dir names absolute and relative
        //WWW_ROOT is a CakePHP constant which returns the full path to the webroot folder
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;

        // create the folder if it does not exist
        if(!is_dir($folder_url))
        {
            mkdir($folder_url);
        }


        // set new absolute folder with order id as subfolder
        $folder_url = WWW_ROOT.$folder.'/'.$orderId;
        // set new relative folder
        $rel_url = $folder.'/'.$orderId;
        // create directory
        if(!is_dir($folder_url))
        {
            mkdir($folder_url);
        }


        // list of permitted file mimetypes
        $permitted = array('image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/x-jg',
            'application/x-troff-msvideo',
            'video/avi',
            'video/msvideo',
            'video/x-msvideo',
            'video/avs-video',
            'image/bmp',
            'image/x-windows-bmp',
            'application/clariscad',
            'text/css',
            'application/msword',
            'text/plain',
            'application/x-compressed',
            'application/x-gzip',
            'text/html',
            'image/x-icon',
            'image/x-jps',
            'image/jutvision',
            'video/mpeg',
            'audio/mpeg',
            'video/x-motion-jpeg',
            'video/quicktime',
            'audio/x-mpeg',
            'video/x-mpeg',
            'video/x-mpeq2a',
            'audio/mpeg3',
            'audio/x-mpeg-3',
            'image/x-niff',
            'application/pdf',
            'image/x-portable-graymap',
            'image/pict',
            'image/x-xpixmap',
            'image/x-portable-anymap',
            'application/mspowerpoint',
            'application/powerpoint',
            'application/vnd.ms-powerpoint',
            'image/x-portable-pixmap',
            'application/x-freelance',
            'image/x-quicktime',
            'application/x-rtf',
            'application/rtf',
            'application/x-tar',
            'application/x-compressed',
            'image/tiff',
            'audio/x-wav',
            'application/wordperfect',
            'image/x-xbitmap',
            'application/excel',
            'application/x-excel',
            'application/x-msexcel',
            'application/vnd.ms-excel',
            'application/x-zip-compressed',
            'application/zip',
            'multipart/x-zip',
            'application/vnd.oasis.opendocument.text',
            'application/vnd.oasis.opendocument.presentation',
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'




        );

         // replace spaces with underscores
        $filename = str_replace(' ', '_', $formdata['name']);
        $mimetypeOK = false;
        // check file mimetype is ok and set typeOK to true if mimetype in array
        foreach($permitted as $type)
        {
            if($type == $formdata['type'])
            {
                $mimetypeOK = true;
                break;
            }
        }
        // if file type ok upload the file
        if($mimetypeOK)
        {
            // switch based on error code
            switch($formdata['error'])
            {
                case 0:
                    // create full filename
                    $full_url = $folder_url.'/'.$filename;
                    $url = $rel_url.'/'.$filename;
                    // upload the file - overwrite existing file
                    $success = move_uploaded_file($formdata['tmp_name'], $url);

                    // if upload was successful
                    if($success)
                    {
                        //save the filepath of the file
                        $result['filepath'][] = $url;
                        $result['filename'][] = $filename;
                        $result['filetype'][] = explode('/',$formdata['type']);
                        if ($result['filetype'][0][0] == 'application')
                            $result['filetype'][0][0] = 'File';
                        if ($result['filetype'][0][0] == 'multipart')
                            $result['filetype'][0][0] = 'File';
                        if ($result['filetype'][0][1] == 'vnd.oasis.opendocument.text' ||
                            $result['filetype'][0][1] == 'vnd.oasis.opendocument.presentation' ||
                            $result['filetype'][0][1] == 'vnd.ms-powerpoint' ||
                            $result['filetype'][0][1] == 'mspowerpoint' ||
                            $result['filetype'][0][1] == 'vnd.openxmlformats-officedocument.presentationml.presentation' ||
                            $result['filetype'][0][1] == 'powerpoint' ||
                            $result['filetype'][0][1] == 'msword' ||
                            $result['filetype'][0][1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document')
                            $result['filetype'][0][0] = 'Document';
                        if (
                            $result['filetype'][0][1] == 'vnd.oasis.opendocument.spreadsheet' ||
                            $result['filetype'][0][1] == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
                            $result['filetype'][0][1] == 'vnd.msexcel' ||
                            $result['filetype'][0][1] == 'x-msexcel' ||
                            $result['filetype'][0][1] == 'x-excel' ||
                            $result['filetype'][0][1] == 'excel' ||
                            $result['filetype'][0][1] == 'ms-excel')
                            $result['filetype'][0][0] = 'spreadsheet';
                        if ($result['filetype'][0][1] == 'pdf')
                            $result['filetype'][0][0] = 'PDF';
                        if ($result['filetype'][0][0] == 'image')
                            $result['filetype'][0][0] = 'Image';
                        if ($result['filetype'][0][0] == 'audio')
                            $result['filetype'][0][0] = 'Audio';
                        if ($result['filetype'][0][0] == 'video')
                            $result['filetype'][0][0] = 'Video';

                    } else
                    {
                        $result['errors'][] = "Something went wrong while uploading ". $filename. " Try again later.";
                    }
                    break;
                case 3:
                    // an error occurred
                    $result['errors'][] = "Something went wrong while uploading ".$filename." Try again later.";
                    break;
                default:
                    // an error occurred
                    $result['errors'][] = "System error uploading ".$filename. "Contact webmaster.";
                    break;
            }
        }
        elseif($formdata['error'] == 4)
        {
            // no file was selected for upload
            $result['errors'][] = "No file Selected";
        }
        else
        {
            // unacceptable file type
            $result['errors'][] = $filename." cannot be uploaded due to unaccepted file type.";
        }


        return $result;
    }


    public function uploadImageFile($folder, $formdata, $promoId)
    {
        // setup dir names absolute and relative
        //WWW_ROOT is a CakePHP constant which returns the full path to the webroot folder
        $folder_url = WWW_ROOT.$folder;
        $rel_url = $folder;

        // create the folder if it does not exist
        if(!is_dir($folder_url))
        {
            mkdir($folder_url);
        }


        // set new absolute folder with promo id as subfolder
        $folder_url = WWW_ROOT.$folder.'/'.$promoId;
        // set new relative folder
        $rel_url = $folder.'/'.$promoId;
        // create directory
        if(!is_dir($folder_url))
        {
            mkdir($folder_url);
        }


        // list of permitted file mimetypes
        $permitted = array('image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/x-jg',
            'image/bmp',
            'image/x-windows-bmp',
            'image/x-jps',
            'image/jutvision',
            'image/x-niff',
            'image/x-portable-graymap',
            'image/pict',
            'image/x-xpixmap',
            'image/x-portable-anymap',
            'image/x-portable-pixmap',
            'image/x-quicktime',
            'image/tiff',
            'image/x-xbitmap',

        );

         // replace spaces with underscores
        $filename = str_replace(' ', '_', $formdata['name']);
        $mimetypeOK = false;
        // check file mimetype is ok and set typeOK to true if mimetype in array
        foreach($permitted as $type)
        {
            if($type == $formdata['type'])
            {
                $mimetypeOK = true;
                break;
            }
        }
        // if file type ok upload the file
        if($mimetypeOK)
        {
            // switch based on error code
            switch($formdata['error'])
            {
                case 0:
                    // create full filename
                    $full_url = $folder_url.'/'.$filename;
                    $url = $rel_url.'/'.$filename;
                    // upload the file - overwrite existing file
                    $success = move_uploaded_file($formdata['tmp_name'], $url);

                    // if upload was successful
                    if($success)
                    {
                        //save the filepath of the file
                        $result['filepath'][] = $url;
                        $result['filename'][] = $filename;
                        $result['filetype'][] = explode('/',$formdata['type']);

                    } else
                    {
                        $result['errors'][] = "Something went wrong while uploading ". $filename. " Try again later.";
                    }
                    break;
                case 3:
                    // an error occurred
                    $result['errors'][] = "Something went wrong while uploading ".$filename." Try again later.";
                    break;
                default:
                    // an error occurred
                    $result['errors'][] = "System error uploading ".$filename. "Contact webmaster.";
                    break;
            }
        }
        elseif($formdata['error'] == 4)
        {
            // no file was selected for upload
            $result['errors'][] = "No file Selected";
        }
        else
        {
            // unacceptable file type
            $result['errors'][] = $filename." cannot be uploaded due to unaccepted file type.";
        }


        return $result;
    }

    public function getZodiac(){
      $zodiacNow = "";
      $now = Time::now();

      if (($now->month == 3 && $now->day > 20) || ($now->month == 4 && $now->day < 20)) {
          $zodiacNow = 1;
      } elseif (($now->month == 4 && $now->day > 19) || ($now->month == 5 && $now->day < 21)) {
          $zodiacNow = 2;
      } elseif (($now->month == 5 && $now->day > 20) || ($now->month == 6 && $now->day < 21)) {
          $zodiacNow = 3;
      } elseif (($now->month == 6 && $now->day > 20) || ($now->month == 7 && $now->day < 23)) {
          $zodiacNow = 4;
      } elseif (($now->month == 7 && $now->day > 22) || ($now->month == 8 && $now->day < 23)) {
          $now->zodiacNow = 5;
      } elseif (($now->month == 8 && $now->day > 22) || ($now->month == 9 && $now->day < 23)) {
          $zodiacNow = 6;
      } elseif (($now->month == 9 && $now->day > 22) || ($now->month == 10 && $now->day < 23)) {
          $zodiacNow = 7;
      } elseif (($now->month == 10 && $now->day > 22) || ($now->month == 11 && $now->day < 22)) {
          $zodiacNow = 8;
      } elseif (($now->month == 11 && $now->day > 21) || ($now->month == 12 && $now->day < 22)) {
          $zodiacNow = 9;
      } elseif (($now->month == 12 && $now->day > 21) || ($now->month == 1 && $now->day < 20)) {
          $zodiacNow = 10;
      } elseif (($now->month == 1 && $now->day > 19) || ($now->month == 2 && $now->day < 19)) {
          $zodiacNow = 11;
      } elseif (($now->month == 2 && $now->day > 18) || ($now->month == 3 && $now->day < 21)) {
          $zodiacNow = 12;
      }

      return $zodiacNow;
    }
}
