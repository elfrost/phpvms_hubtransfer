<?php
/**
 * Hub Transfer Request v.1.0 
 * 
 * phpVMS Module for pilots to submit a Hub Transfer request that is stored in a database 
 * and an option for staff to view all the requests through the admin panel and decide to reject/approve the request.
 * This module is released under the Creative Commons Attribution-Noncommercial-Share Alike  3.0 Unported License
 * Note: Please play fair. I will act immediately upon receiving information of copyright infringement. Thank you.
 * @author Sava Markovic - airserbiavirtual.com
 * @copyright Copyright (c) 2012, Sava Markovic
 * @link http://www.airserbiavirtual.com
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class HubTransfer extends CodonModule 

  {

    public $title = "Hub Transfer Request";
    
    public function index ()
        {
           if (!Auth::LoggedIn())
             {
              $this->set('error', 'You are not logged in.');
              $this->render('hubtransfer/hubtransfer_error.tpl');
             } 
             else
             {
              $hubs = HubTransferData::GetAllHubs(array()); //have to set the values for populating the drop down list
              $this->set('all_hubs', $hubs);
              $this->render('hubtransfer/hubtransfer_index.tpl');
             }
        }
  
    public function submit()
        {
             if ($this->post->reason == '') //checking if the reason filed is empty, you can change == '' to something like > 20 to require more than 20 characters
              {
               $this->set('error', 'You haven\'t specified a reason for your hub transfer request. Please supply one below. Thank you.');
               $this->render('hubtransfer/hubtransfer_error.tpl');
               $hubs = HubTransferData::GetAllHubs(array());
               $this->set('all_hubs', $hubs);
               $this->render('hubtransfer/hubtransfer_index.tpl'); 
              }
              else
              {
                $reqcheck = HubTransferData::CheckRequest(Auth::$userinfo->pilotid); //checking if there is already a request with the logged in pilot's id
                if ($reqcheck > 0)
                  {
                   $this->set('error', 'You already have a hub transfer request submitted for your ID.');
                   $this->render('hubtransfer/hubtransfer_error.tpl');
                   $hubs = HubTransferData::GetAllHubs(array());
                   $this->set('all_hubs', $hubs);
                   $this->render('hubtransfer/hubtransfer_index.tpl');
                  }
                  else 
                  {
                    $data = array(
                            'pilotid'        => Auth::$userinfo->pilotid,
                            'hub_initial'    => Auth::$userinfo->hub,
                            'hub_req' => $this->post->desired_hub,
                            'date_submitted' => date("F jS, Y"),
                            'reason'         => $this->post->reason
                            );
                    //loaded the array, do the magic

                    HubTransferData::AddRequest($data);
                    $this->SendMail();

                  }

              }
        }

    protected function SendMail()
        {
            //sending email to pilot
            $subject = SITE_NAME . ' Hub Transfer Request Submitted';
            $email = Auth::$userinfo->email;
            $message = "This is an automated message sent by our system. <br> Your request has been submitted and processed by our system. You will be contacted when our staff team reviews your request. <Br> Thank you.";
            Util::SendEmail($email, $subject, $message);

            //send email to admin 
            $subject_admin = SITE_NAME . ' A pilot has submitted a Hub Transfer Request';
            $email_admin = ADMIN_EMAIL;
            $message_admin = "A pilot has submitted a Hub Transfer Request. Review the request from the administration panel.";
                                                          
            Util::SendEmail($email_admin, $subject_admin, $message_admin);
            //after all is done, render the submitted tpl file

            $this->render('hubtransfer/hubtransfer_submitted.tpl');

    }
  }



