<h3>Hub Transfer Request Admin</h3>
<?php echo $msg ?>
<?php 
if ($all)
{
	?>
<table id="grid"></table>
<div id="pager"></div>
<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>Pilot ID</th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Initial Hub</th>
	<th>Requested Hub</th>
	<th>Current Hub</th>
	<th>Reason</th>
	<th>Status</th>
	<th>Set Status</th>
</tr>
</thead>
<tbody>

<?php
foreach($all as $item)
{

	
?>
<tr>
	<td width="1%" nowrap><a href="<?php echo SITE_URL?>/admin/index.php/pilotadmin/viewpilots?action=viewoptions&pilotid=<?php echo $item->pilotid?>"><?php echo $item->pilotid ?></td>
	<td><?php echo $item->firstname ?> </td>
	<td><?php echo $item->lastname ?> </td>
	<td><?php echo $item->hub_initial ?>
	</td>
	<td><?php echo $item->hub_req ?></td>
	<td><?php echo $item->hub?></td>
	<td><?php echo $item->reason?></td>

	<td><?php 
		 switch($item->status)
		 {
		 	case 0:
		 	echo '<font color=\'gray\'>Pending...</font>';
		 	break;
		 	case 1:
		 	echo '<font color=\'red\'>Denied</font>';
		 	break;
		 	case 2:
		 	echo '<font color=\'green\'>Approved</font>';
		 	break;
		 }
		 ?>
		 
	<td><input type="submit" name="submit" value="Approve"onClick="parent.location='<?php echo SITE_URL?>/admin/index.php/hubtransfer/approve?id=<?php echo $item->pilotid?>&hub=<?php echo $item->hub_req;?>&email=<?php echo $item->email;?>'"/>
	
	<input type="submit" name="submit" value="Deny" onClick="parent.location='<?php echo SITE_URL?>/admin/index.php/hubtransfer/deny?id=<?php echo $item->pilotid?>'"/>

	<input type="submit" name="submit" value="Pending" onClick="parent.location='<?php echo SITE_URL?>/admin/index.php/hubtransfer/pending?id=<?php echo $item->pilotid?>'"/></td>

<?php
}
}else{
	echo 'There are no active requests.';
}
?>
</tbody>
</table>
