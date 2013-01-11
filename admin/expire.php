<?php
$synergy = 6;
include $adminheader;

?>
<div align="center"><h3>OpEx Markets Admin<br />
Options Expiration</h3></div>
<br>
<br>
<?php
include '../global.php';
$result = mysql_query("SELECT * FROM `options` WHERE id = '".$_REQUEST['id']."' AND result = ''");

if (mysql_num_rows($result) == 0) {
echo 'That option was not found!';
}
else {
$option = mysql_fetch_array($result);
echo '<b>Complete Trading For: '.$option['name'].'</b><br /><br /><br />Typically, the winning options contracts will be sold at 100 and the losing contracts at 0.  However, to accomodate for special circumstances, contracts can be priced at any value when expiring an option through this page.<br /><br />';


if ($_REQUEST['op'] == 'post') {
	
	
	
	$result = mysql_query("SELECT * FROM holdings WHERE `option` = '".$option['id']."' AND `direction` = '".$_REQUEST['win']."'");
	$earnings = 0;
		while ($contract = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if ($contract['direction'] == 'up') {
		$earnings = $contract['shares']*$_REQUEST['up'];
		$ps = $_REQUEST['up'];
		}
		elseif ($contract['direction'] == 'down') {
		$earnings = $contract['shares']*$_REQUEST['down'];
		$ps = $_REQUEST['down'];
		}
		
		if ($earnings > 0) {
		$res2 = mysql_query("SELECT cash FROM users WHERE username LIKE '".$contract['username']."'");
		$usercash = mysql_fetch_row($res2);
		$newcash = $earnings + $usercash[0];
		mysql_query("UPDATE users SET cash = '$newcash' WHERE username LIKE '".$contract['username']."'");
		mysql_query("INSERT INTO pmkt.transactions SET username = '".$contract['username']."', amount = '$earnings', type = 'credit', balance = '$newcash', description = 'Options Expiration Profit', details = 'Owned ".$_REQUEST['shares']." shares of <b>".$option['name'].".".ucwords($contract['direction'])."</b>.  Earnings: $ps per share.  Payouts (per share): Up = ".$_REQUEST['up'].". Down = ".$_REQUEST['down'].". Win: ".ucwords($_REQUEST['win']).".', date = NOW()");
		}
		
		
		}
		
		if ($_REQUEST['win'] == 'up') {
		$newpricephr = "`price` = '".$_REQUEST['up']."'";
		}
		if ($_REQUEST['win'] == 'down') {
		$newpricephr = "`price` = '".$_REQUEST['down']."'";
		}
	mysql_query("DELETE FROM holdings WHERE `option` = '".$option['id']."'");
	mysql_query("UPDATE `options` SET `result` = '".$_REQUEST['win']."', $newpricephr WHERE id = '".$option['id']."'");
	echo '<br /><br /><font color="#394563" size="5">All contracts have been paid and trading for this option is complete!</font><br /><br />';
	exit;
	
}

?><form action="expire.php?op=post&id=<?=$option['id']?>" method="post">
<table width="70%" border="0" align="center" cellspacing="0">
  <tr>
    <td width="50%">Winning Contracts</td>
    <td><select class="smborder" name="win" id="win">
      <option value="up">up</option>
      <option value="down">down</option>
    </select>    </td>
  </tr>
  <tr>
    <td>Final UP Price</td>
    <td><input name="up" type="text" class="smborder" id="up" value="100" maxlength="3"></td>
  </tr>
  <tr>
    <td>Final DOWN Price</td>
    <td><input name="down" type="text" class="smborder" id="down" value="0" maxlength="3"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><input class="smborder" name="submit" type="submit" value="Complete Option Trading" /></div></td>
    </tr>
</table>
</form>
<?php

}

?>
