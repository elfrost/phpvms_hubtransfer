<?php

/**
 * Hub Transfer Request  v1.0
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

class HubTransferData extends CodonData
 {

	public function CheckRequest($pilotid) //used to check for exisitng requests with pilot id of logged in pilot
	{
		$query = "SELECT * FROM hubtransfer WHERE pilotid='$pilotid'";
		$sql = mysql_query($query);
		$count = mysql_num_rows($sql);
		return $count;
	}

	public function GetAllHubs()  //used to get all the hubbs. Notice that the we skip the current hub as there is no point in displaying it
	{
		$pilot_hub = Auth::$userinfo->hub; 
		$query = "SELECT icao FROM ' . TABLE_PREFIX . 'airports  WHERE hub='1' AND icao!= '$pilot_hub'";
		$sql   = DB::get_results($query);
		return $sql;

	}
	public function AddRequest ($data) //used to enter the request in the db
	{

		$pilotid        = DB::escape($data['pilotid']);
 		$hub_initial    = DB::escape($data['hub_initial']);
 		$hub_req        = DB::escape($data['hub_req']);
 		$date_submitted = DB::escape($data['date_submitted']);
 		$reason 		= DB::escape($data['reason']);
 		$sql            = "INSERT INTO hubtransfer (pilotid, hub_initial, hub_req, date_submitted, reason) VALUES ('$pilotid', '$hub_initial', '$hub_req', '$date_submitted', '$reason')";
 		$insert = DB::query($sql);
	

	}

	public function GetAllRequests () //gets all the information for admin panel by joining the hubtransfer with the pilots table for other info
	{
		$sql   = "SELECT hubtransfer.pilotid,
						' . TABLE_PREFIX . 'pilots.firstname,
						 ' . TABLE_PREFIX . 'pilots.lastname,
						 ' . TABLE_PREFIX . 'pilots.email,
						 ' . TABLE_PREFIX . 'pilots.hub,
						 hubtransfer.hub_initial,
						 hubtransfer.hub_req,
						 hubtransfer.date_submitted,
						 hubtransfer.reason,
						 hubtransfer.status
				  FROM hubtransfer JOIN ' . TABLE_PREFIX . 'pilots 
				  ON hubtransfer.pilotid = ' . TABLE_PREFIX . 'pilots.pilotid";



		$ret = DB::get_results($sql);
		return $ret;
		

	}

	public function approve ($id) //approving the request (displays "approved" in admin panel)
	{
		$sql  = "UPDATE hubtransfer SET status='2' WHERE pilotid='$id'";
		$query = DB::query($sql);
	}

	public function ChangeHub ($data) //actual query that changes the hub in the database
	{
		$pilotid = $data['pilotid'];
		$hub 	 = $data['hub'];
		$email 	 = $data['email'];
		$sql     = "UPDATE ' . TABLE_PREFIX . 'pilots SET hub='$hub' WHERE pilotid='$pilotid'";
		$query   = DB::query($sql);
	}

	public function deny($id) //denying the request 
	{
		$sql = "UPDATE hubtransfer SET status='1' WHERE pilotid='$id'";
		$query = DB::query($sql);

	}
	public function pending($id) //setting it as pending again, if needed. No mail is sent again if pending is re-set
	{
		$sql = "UPDATE hubtransfer SET status='0' WHERE pilotid='$id'";
		$query = DB::query($sql);
		
	}

	public function delete($id)
	{
		$sql = "DELETE FROM hubtransfer WHERE pilotid='$id'";
		$query = DB::query($sql);
		return mysql_affected_rows();
	}

}








