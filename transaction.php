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



<div align="center">
<?php
include 'global.php';


if ($_REQUEST['id']) { 
$result = mysql_query("SELECT * FROM transactions WHERE id = '".$_REQUEST['id']."' AND username LIKE '".$_SESSION['txb_loggedin']."'");
if (mysql_num_rows($result) == 0) {
echo 'Sorry, but this is an invalid transaction.  For help please contact ' . $supportemail;
exit;
}
$tact = mysql_fetch_array($result);
?>

<div align="center"><strong>Transaction Detail</strong><br>
  <br>
  <br>
  
</div>
<table width="100%" border="0" align="center" cellspacing="15">
  <tr>
    <td width="37%" valign="top">Transaction Type</td>
    <td width="63%" valign="top"><?=ucwords($tact['type']) ?></td>
  </tr>
  <tr>
    <td valign="top">Timestamp</td>
    <td valign="top"><?=$tact['date']?></td>
  </tr>
  <tr>
    <td valign="top">Amount</td>
    <td valign="top"><?=number_format(round($tact['amount'],2),2)?></td>
  </tr>
  <tr>
    <td valign="top">Balance After Transaction</td>
    <td valign="top"><?=number_format($tact['balance'],2)?></td>
  </tr>
  <tr>
    <td valign="top">Details</td>
    <td valign="top"><?=$tact['description']?>: <?=$tact['details']?></td>
  </tr>
</table>
<?php }
else {
?>

<strong>My Transactions</strong><br /><br />

<?php

$result = mysql_query("SELECT * FROM transactions WHERE username LIKE '".$_SESSION['txb_loggedin']."' ORDER BY date DESC");
if (mysql_num_rows($result) == 0) {
echo '<br /><br />Sorry, no transactions were found for this account!';
}
else {

echo '<table width="100%" border="0" cellspacing="0">';


			while ($tact = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$date = explode(" ",$tact['date']);
			$date = explode('-',$date[0]);
	
			
			echo '<tr onmouseover="this.className=\'border\'" onmouseout="this.className=\'\'" class=""><td width="20%">'.$date[1].'-'.$date[2].'-'.$date[0].'</td><td width="10%"><img src="images/'.$tact['type'].'.gif"></td><td>'.$tact['description'].'</td><td align="right">[<a href="?id='.$tact['id'].'">details</a>]</td></tr>';
			}


			echo '</table>';


}

 } 
?>
</div></body></html>
