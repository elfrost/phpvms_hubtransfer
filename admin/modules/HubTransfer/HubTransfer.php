<?php

/**
 * Hub Transfer Request Module v1.0
 * 
 * phpVMS Module for pilots to submit a Hub Transfer request that is stored in a database 
 * and an option for staff to view all the requests through the admin panel, and reject/approve them.
 * This module is released under the Creative Commons Attribution-Noncommercial-Share Alike  3.0 Unported License
 * You are free to redistribute and alter this work as you wish but you must keep the original 'copyright' information on all the places it comes in the original work.
 * You are not allowed to delete the copyright information and/or gain any profit by adopting or using this module.
 *
 * @author Sava Markovic - airserbiavirtual.com
 * @copyright Copyright (c) 2012, Sava Markovic
 * @link http://www.airserbiavirtual.com
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class HubTransfer extends CodonModule {

    public $title = "Hub Transfer Admin";
    
    public function HTMLHead() //function for sidebar
        {
           $this->set('sidebar', 'hubtransfer/hubtransfer_admin_sidebar.tpl');
        }

    public function NavBar () 
        {
            echo '<li><a href="'.SITE_URL.'/admin/index.php/hubtransfer">Hub Transfer Admin</a></li>';
        }

    public function index ()
        {
            $requests = HubTransferData::GetAllRequests(array());
            $this->set('all', $requests);
            $this->render('hubtransfer/hubtransfer_admin_index.tpl');
        }

    public function approve () //set as approved, change the hub and send the mail
        {
            $id    = $this->get->id;
            $hub   = $this->get->hub;
            $email = $this->get->email;
            $data = array(
                    'pilotid' => $id,
                    'hub'     => $hub,
                              );

            HubTransferData::approve($id);
            HubTransferData::ChangeHub($data); //here we call for the hub change and below send an email
            $subject = SITE_NAME. ' - Hub Transfer Information';
            $msg     = 'Your request has been approved and your hub has now been changed as per your submitted request. <br>
            .';
            Util::SendEmail($email, $subject, $msg);
            //reloading the list
            $requests = HubTransferData::GetAllRequests(array());
            $this->set('all', $requests);
            $this->set('msg', 'The status has been changed.');
            $this->render('hubtransfer/hubtransfer_admin_index.tpl');
        }

   
     public function deny () //method for denying the requests. Displays denied and sends the pilot an email 
        {
            $id = $this->get->id;
            HubTransferData::deny($id);
            $subject = SITE_NAME. ' - Hub Transfer Information';
            $msg     = "Your hub has now been changed as per your submitted request.<br> Staff";
            Util::SendEmail($email, $subject, $msg);
            //reload the list below, for ease of use
            $requests = HubTransferData::GetAllRequests(array());
            $this->set('all', $requests);
            $this->set('msg', 'The status has been changed.');
            $this->render('hubtransfer/hubtransfer_admin_index.tpl');
        }

     public function pending () //set the status as pending and reload the list 
        {
            $id = $this->get->id;
            HubTransferData::pending($id);
            $requests = HubTransferData::GetAllRequests(array());
            $this->set('all', $requests);
            $this->set('msg', 'The status has been changed.');
            $this->render('hubtransfer/hubtransfer_admin_index.tpl');
        }



    
   
}

