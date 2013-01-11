<?php
$synergy = 6;
include $adminheader;

?>
<div align="center"><h3>OpEx Markets Admin<br />
Users</h3></div>
<br>
<br>
<br>

<?php
include '../global.php';
$result = mysql_query("SELECT * FROM pmkt.users WHERE username LIKE '".$_REQUEST['username']."'");

if (mysql_num_rows($result) == 0) {
echo 'Sorry, but the username you entered was not found in the OpEx system.';
}

else {

$user = mysql_fetch_array($result);


if ($_REQUEST['mode'] == 'cash' && $_REQUEST['amount']) {
	if ($_REQUEST['type'] == 'debit') {
	$user['cash'] = $user['cash'] - $_REQUEST['amount'];
	}
	if ($_REQUEST['type'] == 'credit') {
	$user['cash'] = $user['cash'] + $_REQUEST['amount'];
	}
	
	mysql_query("UPDATE pmkt.users SET cash = '".$user['cash']."' WHERE id = '".$user['id']."'");
	mysql_query("INSERT INTO transactions SET type = '".$_REQUEST['type']."', amount = '".$_REQUEST['amount']."', username = '".$user['username']."', balance = '".$user['cash']."', description = '".$_REQUEST['description']."', details = '".$_REQUEST['details']."', date = NOW()");
	
	echo '<br /><br /><font size="5" color="#394563">Users account balance has been updated</font><br /><br />';
	
}





echo '<b>Profile for '.$user['username'].'</b><br /><br />Cash Balance: '.$user['cash'].'<br /><br />Update Cash:<br />
<form action="users.php?mode=cash&username='.$user['username'].'" method="post">
<table width="30%" border="0" cellspacing="0">
  <tr>
    <td>Transaction Type</td>
    <td><select class="smborder" name="type"><option value="credit">Credit</option><option value="debit">Debit</option></select></td>
  </tr>
  <tr>
    <td>Amount</td>
    <td><input class="smborder" length="40" type="text" name="amount" id="amount" /></td>
  </tr>
  <tr>
    <td>Description (short)</td>
    <td><input class="smborder" length="40" type="text" name="description" id="description" /></td>
  </tr>
  <tr>
    <td>Details (longer)</td>
    <td><input class="smborder" length="40" type="text" name="details" id="details" /></td>
  </tr>
    <tr>
    <td colspan="2"><input class="smborder" type="submit" name="submit" value="Update" /></td>
  </tr>
</table></form>';




}

?>
