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
?>
<p>
<h2>Hub Transfer Request</h2>
Welcome to the Hub Transfer Request Page. <br>
Below you will find details about your account and information on submitting a Hub Transfer Request.
</p>
<p>

Your Information: <Br/>
<table border="0px" bordercolor="transparent" style="background-color:none"  cellpadding="3" cellspacing="3">
	<tr>
		<td><strong>Name</strong></td>
		<td><?php echo Auth::$userinfo->firstname;  ?><td>
	</tr>
	<tr>
		<td><strong>Surname</strong></td>
		<td><?php echo Auth::$userinfo->lastname;  ?><td>
	</tr>
	<tr>
		<td><strong>Email</strong></td>
		<td><?php echo Auth::$userinfo->email;  ?><td>
	</tr>
	<tr>
		<td><strong>Pilot ID</strong></td>
		<td><?php echo PilotData::GetPilotCode(Auth::$userinfo->code, Auth::$userinfo->pilotid) ?> <td>
	</tr>
</table>
Please confirm that your email adress is still active as that is the place we will be sending you information about your request. 
</p>
<hr/>
<p>
<b>Hub Transfer Request Information </b><br/><br/>
The Hub Transfer Request that you will submit will be stored in our database and sent for review to the relevant staff members. You will be sent two emails regarding your request. The first one will confirm the information submitted and the second one will inform you of the staff decision. Please note that we may or may not approve your request. This is dependant on pilot staffing, hub capacity and other factors. 
<hr />


<table border="0px" bordercolor="transparent" style="background-color:none"  cellpadding="3" cellspacing="3">
	<form method="post" action="<?php echo url('/hubtransfer/submit');?>">
	<tr>
		<td><strong>Pilot ID:</strong></td>
		<td><?php echo Auth::$userinfo->code.Auth::$userinfo->pilotid ;?></td>
	<tr>
		<td><strong>Your current hub: </strong></td>
		<td><?php echo Auth::$userinfo->hub; ?><td>
	</tr>
	<tr>
		<td><strong>Desired Transfer Hub: </strong></td>
		<td><select name="desired_hub" id="desired_hub">
		<?php
		if ($all_hubs){

		foreach($all_hubs as $hub)
			{
			echo '<option value="'.$hub->icao.'">'.$hub->icao.'</option>';
			}
					  }
		else 
			{
			 echo 'No hubs.';
			}
		?>

		<td>
	</tr>
	<tr>
		<td><strong>Reason for hub transfer request: </strong></td>
		<td><textarea name="reason" cols="25" rows="5"></textarea><br></td>
	</tr>
	<tr>
		<td><input type="submit" value="Submit!"/></td>
		
		</tr></table>


</form>


</p>
&copy <?php echo  date(Y) ?> Sava Markovic - All rights reserved 


