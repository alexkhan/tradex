<?php
include 'global.php';
$result = mysql_query("SELECT * FROM holdings WHERE id = '".$_REQUEST['id']."' AND username LIKE '".$_SESSION['txb_loggedin']."'");
if (mysql_num_rows($result) == 0) {
echo 'Sorry, but this is an invalid holding.  It could not be found for this account.  For help, please contact' . $supportemail;
exit;
}
$holding = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM options WHERE id = '".$holding['option']."'");
$option = mysql_fetch_array($result);
?>
<html><head>
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
</style></head>

<body>

<table width="100%" height="100"><tr><td></td></tr></table>


<div align="center"><strong>Sell <?=$option['name'].'.'.ucwords($holding['direction'])?></strong><br>
<br>
<br>

<?php
if ($_REQUEST['mode'] == 'preview') {
	if ($_REQUEST['shares'] > $holding['shares'] || $_REQUEST['shares'] < 1 || !is_numeric($_REQUEST['shares']) || strstr($_REQUEST['shares'],".")|| strstr($_REQUEST['shares'],"+") || strstr($_REQUEST['shares'],"-") || strstr($_REQUEST['shares'],"/")) {
	echo '<font color="#FF0000">You are trying to sell more shares than you own or you have not entered a valid number of shares to sell.</font>';
	exit;
	}
	if ($holding['direction'] == 'up') {
	
	$projectedprice = 0;
	$yes = $option['outstandinglongs'];
	for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$projectedprice = $projectedprice + round((($yes) / ($yes + $option['outstandingshorts']) * 100),2);
	$yes = $yes - 1;
	}
	}
	elseif ($holding['direction'] == 'down') {
	
	$projectedprice = 0;
	$no = $option['outstandingshorts'];
	for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$projectedprice = $projectedprice + round(100-((($option['outstandinglongs']) / ($option['outstandinglongs'] + $no)) * 100),2);
	$no = $no - 1;
	}
	}
	echo 'Estimated Profits: '.$projectedprice.'<br /><br /><form action="sell.php?mode=sell&id='.$_REQUEST['id'].'&shares='.$_REQUEST['shares'].'&direction='.$_REQUEST['direction'].'" method="post"><br /><br /><input type="submit" name="submit" class="border" value="Confirm Order" /></form>';
}
else if ($_REQUEST['mode'] == 'sell') {



if ($holding['direction'] == 'up') {
	
	$projectedprice = 0;
	$yes = $option['outstandinglongs'];
	for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$projectedprice = $projectedprice + round((($yes) / ($yes + $option['outstandingshorts']) * 100),2);
	$yes = $yes - 1;
	}

	}
	elseif ($holding['direction'] == 'down') {
	
	$projectedprice = 0;
	$no = $option['outstandingshorts'];
	for ( $counter = 1; $counter <= $_REQUEST['shares']; $counter += 1) {
	$projectedprice = $projectedprice + round(100-((($option['outstandinglongs']) / ($option['outstandinglongs'] + $no) * 100)),2);
	$no = $no - 1;
	}

	}
	
	
	//calculate price for option
	if ($holding['direction'] == 'up') {
	$newprice = round((($option['outstandinglongs'] - $_REQUEST['shares']) / ($option['outstandinglongs'] + $option['outstandingshorts'] - $_REQUEST['shares']) * 100),2);
	$totalshares = $option['outstandinglongs'] - $_REQUEST['shares'];
	$newvolume = $option['shares'] - $_REQUEST['shares'];
	mysql_query("UPDATE options SET price = '$newprice', outstandinglongs = '$totalshares', shares = '$newvolume' WHERE id = '".$holding['option']."'");
	}
	else if ($holding['direction'] == 'down') {
	$newprice = round((($option['outstandinglongs']) / ($option['outstandinglongs'] + $option['outstandingshorts'] - $_REQUEST['shares']) * 100),2);
	$totalshares = $option['outstandingshorts'] - $_REQUEST['shares'];
	$newvolume = $option['shares'] - $_REQUEST['shares'];
	mysql_query("UPDATE options SET price = '$newprice', outstandingshorts = '$totalshares', shares = '$newvolume' WHERE id = '".$holding['option']."'");
	}
	
	include 'inc/historical.php';
	
	echo '<b>Sale complete!</b><br /><br />'.$_REQUEST['shares'].' shares of '.$option['name'].'.'.$holding['direction'].' sold.<br /><br /><br />Profit Credited To Your Account: '.$projectedprice;
	$nab = round($user['cash'] + $projectedprice - .01,2);
	echo "<br />New Account Balance: $nab";
	mysql_query("INSERT INTO pmkt.transactions SET username = '".$_SESSION['txb_loggedin']."', amount = '$projectedprice', type = 'credit', balance = '$nab', description = 'Stock Sell', details = 'You sold ".$_REQUEST['shares']." shares of ".$option['name'].".".ucwords($holding['direction']).".', date = NOW()");
	mysql_query("UPDATE users SET cash = '$nab' WHERE username LIKE '".$_SESSION['txb_loggedin']."'");
	
	if ($_REQUEST['shares'] >= $holding['shares']) {
	mysql_query("DELETE FROM holdings WHERE id = '".$holding['id']."' LIMIT 1");
	}
	else if ($_REQUEST['shares'] < $holding['shares']) {
	$newusershares = $holding['shares'] - $_REQUEST['shares'];
	mysql_query("UPDATE holdings SET shares = '$newusershares' WHERE id = '".$holding['id']."'");
	}

include 'marketvalue.php';
}

else {

echo '<br /><br /><img src="'.$option['image'].'" width="100" height="100" /><br /><br />';
?>

<form action="sell.php?mode=preview&id=<?=$holding['id']?>" method="post">
  <p>Number of Shares to Sell
  <br>
  <input name="shares" type="text" class="smborder" id="shares" value="<?=$holding['shares']?>" maxlength="3" />
  </p>
  <p>
    <input name="submit" type="submit" class="border" value="Preview Order" />
    </p>
</form>
<?php } ?></div></body></html>
