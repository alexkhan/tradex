<?php
include 'global.php';
$result = mysql_query("SELECT * FROM options WHERE id = '".$_REQUEST['id']."' AND result = ''");
if (mysql_num_rows($result) == 0) {
echo 'Sorry, but this is an invalid option contract.  It either does not exist in the system or has already expired and cannot be traded.  For help, please contact . $supportemail;
exit;
}
$option = mysql_fetch_array($result);
?><html><head>
<style>
html, body {
height: 100%;
}
body,td,th {

	/*font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10pt;
	*/
	font-family:"lucida grande", tahoma, verdana, arial, sans-serif;
	font-size:11px;
	color: #000;
}
.border {
	background-color: CACACA;
	border-width: 1px; 
	border-style: solid; 
	border-color: 666666; 
}
.border2 {
	background-color: #999999;
	border-width: 1px; 
	border-style: dashed; 
	border-color: 666666; 
}
.smborder {
	background-color: #FFF;
	border-width: 1px; 
	border-style: solid; 
	border-color: 666666;
	font-family:"lucida grande", tahoma, verdana, arial, sans-serif;
	font-size:11px;
	text-align:center;
}
.smborder2 {
	background-color: #FFF;
	border-width: 1px; 
	border-style: dashed; 
	border-color: 666666;
	font-family:Arial, Helvetica, sans-serif;
	font-size:8px;
}
h3 {
color: #A10606;
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:18px;
}
a:link {
	color: #A10606;
}
a:visited {
	color: #A10606;
}
a:hover {
	color:#FF3300;
}
a:active {
	color: #A10606;
}
/* set millions of background images */
.rbroundbox { background: url(images/nt.gif) repeat; }
.rbtop div { background: url(images/tl.gif) no-repeat top left; }
.rbtop { background: url(images/tr.gif) no-repeat top right; }
.rbbot div { background: url(images/bl.gif) no-repeat bottom left; }
.rbbot { background: url(images/br.gif) no-repeat bottom right; }

/* height and width stuff, width not really nessisary. */
.rbtop div, .rbtop, .rbbot div, .rbbot {
width: 100%;
height: 7px;
font-size: 1px;
}
.rbcontent { margin: 0 7px; }
.rbroundbox { width: 90%; margin: 1em auto; }
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image:url(images/modalheader.jpg);
	background-repeat:repeat-x;
}
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head><body>
<table width="100%" height="100"><tr><td></td></tr></table>

<div align="center">
<strong>Buy <?=$option['name'].'.'.ucwords($_REQUEST['direction'])?></strong>


<?php

if ($_REQUEST['mode'] == 'preview') {

	if (!is_numeric($_REQUEST['shares']) || $_REQUEST['shares'] < 1 || strstr($_REQUEST['shares'],".")  || strstr($_REQUEST['shares'],"+") || strstr($_REQUEST['shares'],"-") || strstr($_REQUEST['shares'],"/")) {
	echo '<br /><br /><font color="#FF0000">You have entered an invalid number of shares.</font>';
	exit;
	}
	
	$result = mysql_query("SELECT * FROM holdings WHERE `option` = '".$option['id']."' AND direction NOT LIKE '".$_REQUEST['direction']."' AND username LIKE '".$_SESSION['txb_loggedin']."'");
	if (mysql_num_rows($result) != 0) {
	echo '<br /><br /><font color="#CC0000"><b>Error!</b><br />You can not own "up" and "down" shares of the same option.  You must sell your other shares before you continue.</font>';
	exit;
	}


	//Price calculation loop
	$projectedprice = 0;
	
	if ($_REQUEST['direction'] == 'up') {
	for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$projectedprice = $projectedprice + (($option['outstandinglongs'] + $counter) / ($option['outstandinglongs'] + $option['outstandingshorts'] + $counter) * 100);
	}
	}
	else if ($_REQUEST['direction'] == 'down') {
	for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$projectedprice = $projectedprice + (100-(($option['outstandinglongs']) / ($option['outstandinglongs'] + $option['outstandingshorts'] + $counter) * 100));
	}
	}
	
	if ($projectedprice > $user['cash']) {
	echo '<br /><br /><b>Error!</b><br /><br />This transaction would cost '.number_format(round($projectedprice,2),2).' but your cash available for trading is only '.number_format($user['cash'],2).'.  Please reduce the number of shares or add cash into your account and try again.';
	} else {
	
	echo '<br /><br /><br />Estimated Price: '.number_format(round($projectedprice,2),2).'<br /><br /><form action="trade.php?mode=buy&id='.$_REQUEST['id'].'&shares='.$_REQUEST['shares'].'&direction='.$_REQUEST['direction'].'" method="post"><br /><br /><input type="submit" name="submit" value="Confirm Order" class="border" /></form>';
}}


else if ($_REQUEST['mode'] == 'buy') {
	//determine cost loop
	$finalcost = 0;
	if ($_REQUEST['direction'] == 'up') {
	for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$finalcost = $finalcost + (($option['outstandinglongs'] + $counter) / ($option['outstandinglongs'] + $option['outstandingshorts'] + $counter) * 100);
	}
	}
	else if ($_REQUEST['direction'] == 'down') {
	
		for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$finalcost = $finalcost + (100-(($option['outstandinglongs']) / ($option['outstandinglongs'] + $option['outstandingshorts'] + $counter) * 100));
	}
	}
	
	
		if ($finalcost > $user['cash']) {
	echo '<br /><b><font color="#CC0000">Transaction Failed</font></b><br />This order could not be place.  '.$_REQUEST['shares'].' shares would cost '.number_format(round($finalcost,2),2).' but your cash available for trading is only '.number_format($user['cash'],2).'.  Please reduce the number of shares or add cash into your account and try again.';
	exit;
	}
	
	
	//update users currency
	$nc = round($user['cash'] - $finalcost,2);
	mysql_query("UPDATE users SET cash = '$nc' WHERE username LIKE '".$_SESSION['txb_loggedin']."'");
	
	//calculate price for option
	if ($_REQUEST['direction'] == 'up') {
	$newprice = round((($option['outstandinglongs'] + $_REQUEST['shares']) / ($option['outstandinglongs'] + $option['outstandingshorts'] + $_REQUEST['shares']) * 100),2);
	$totalshares = $_REQUEST['shares'] + $option['outstandinglongs'];
	$newvolume = $option['shares'] + $_REQUEST['shares'];
	mysql_query("UPDATE options SET price = '$newprice', outstandinglongs = '$totalshares', shares = '$newvolume' WHERE id = '".$_REQUEST['id']."'");
	}
	else if ($_REQUEST['direction'] == 'down') {
	$newprice = round((($option['outstandinglongs']) / ($option['outstandinglongs'] + $option['outstandingshorts'] + $_REQUEST['shares']) * 100),2);
	$totalshares = $_REQUEST['shares'] + $option['outstandingshorts'];
	$newvolume = $option['shares'] + $_REQUEST['shares'];
	mysql_query("UPDATE options SET price = '$newprice', outstandingshorts = '$totalshares', shares = '$newvolume' WHERE id = '".$_REQUEST['id']."'");
	}
	
	//create historical
include 'inc/historical.php';
	
	//give a holding record
	$result = mysql_query("SELECT * FROM holdings WHERE `option` = '".$option['id']."' AND username LIKE '".$_SESSION['txb_loggedin']."' AND direction = '".$_REQUEST['direction']."'");
			
			if (mysql_num_rows($result) > 0) {
			$holding = mysql_fetch_array($result);
			$shareamount = $holding['shares'] + $_REQUEST['shares'];
			$calcnewprice = round((($holding['shares'] * $holding['price'])+($finalprice))/($holding['shares'] + $_REQUEST['shares']),2);
			mysql_query("UPDATE holdings SET price = '$calcnewprice', shares = '$shareamount' WHERE id = '".$holding['id']."'");
			}
			else {
			$avgprice = $finalcost / $_REQUEST['shares'];
			mysql_query("INSERT INTO holdings SET `option` = '".$option['id']."', username = '".$_SESSION['txb_loggedin']."', direction = '".$_REQUEST['direction']."', shares = '".$_REQUEST['shares']."', price = '". round($finalcost / $_REQUEST['shares'],2) ."'");
			}
			mysql_query("INSERT INTO pmkt.transactions SET username = '".$_SESSION['txb_loggedin']."', amount = '$finalcost', type = 'debit', balance = '$nc', description = 'Stock Buy', details = 'You bought ".$_REQUEST['shares']." shares of ".$option['name'].".".ucwords($_REQUEST['direction']).".', date = NOW()");
			echo '<br /><br />Transaction Complete.  Your new available account balance is '.$nc.'.';
			
			
	include 'marketvalue.php';
}

else {
?>
<br /><br />

<div align="center">
<table width="55%">
	<tr>
		<td align="center"><strong>Volume</strong><br /><?=($option['outstandinglongs'] + $option['outstandingshorts']); ?></td>
    </tr>
    
	<tr>
		<td align="center"><strong>Rules</strong><br /><?=$option['rules'] ?></td>
    </tr>    
	<tr>
		<td align="center"><img src="<?=$option['image']?>" width="100" height="100" /></td>
    </tr>        
</table>    
</div>

<form action="trade.php?mode=preview&id=<?=$_REQUEST['id']?>&direction=<?=$_REQUEST['direction']?>" method="post">
  <p>Number of Shares to Buy<br />
  <input name="shares" type="text" id="shares" maxlength="3" class="smborder" />
  </p>
  <p>
    <input type="submit" name="submit" value="Preview Order" class="border" />
    </p>
</form>

<?php } ?>

</div>
</body></html>
