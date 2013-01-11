<?php
//$synergy = 8;
include 'global.php';

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?=$baseurl?>/inc/subModal.css" />
	<script type="text/javascript" src="<?=$baseurl?>/inc/common.js"></script>
	<script type="text/javascript" src="<?=$baseurl?>/inc/subModal.js"></script>
<title>OpEx</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
html, body {
height: 100%;
background-color:#808080;
color:#FFF;
}
 div#footer{
  position:absolute;
  bottom:0;
  left:0;
  width:100%;
  height:<length>;
 }
  @media screen{
  body>div#footer{
   position: fixed;
  }
 }
body,td,th {

	/*font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10pt;
	*/
	font-family:"lucida grande", tahoma, verdana, arial, sans-serif;
	font-size:11px;
	color:#FFFFFF;
	
}
td,th {
color: #000;
}
.border {
	background-color: CACACA;
	border-width: 1px; 
	border-style: solid; 
	border-color: 666666; 
}
.border2 {
	background-color:#DDDDDD;
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

.rbroundbox { background: url(<?=$baseurl?>/images/nt.gif) repeat; }
.rbtop div { background: url(<?=$baseurl?>/images/tl.gif) no-repeat top left; }
.rbtop { background: url(<?=$baseurl?>/images/tr.gif) no-repeat top right; }
.rbbot div { background: url(<?=$baseurl?>/images/bl.gif) no-repeat bottom left; }
.rbbot { background: url(<?=$baseurl?>/images/br.gif) no-repeat bottom right; }


.rbtop div, .rbtop, .rbbot div, .rbbot {
width: 100%;
height: 7px;
font-size: 1px;
}
.rbcontent { margin: 0 7px; }
.rbroundbox { width: 90%; margin: 1em auto; }



.rbroundboxnav { background: url(<?=$baseurl?>/images/nt.gif) repeat; }
.rbtopnav div { background: url(<?=$baseurl?>/images/tl.gif) no-repeat top left; }
.rbtopnav { background: url(<?=$baseurl?>/images/tr.gif) no-repeat top right; }
.rbbotnav div { background: url(<?=$baseurl?>/images/bl.gif) no-repeat bottom left; }
.rbbotnav { background: url(<?=$baseurl?>/images/br.gif) no-repeat bottom right; }
.rbtopnav div, .rbtopnav, .rbbotnav div, .rbbotnav {
width: 100%;
height: 7px;
font-size: 1px;
}
.rbroundboxnav { width: 975; margin: 1em auto; }

</style>

</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>


<div id="footer"> 
Copyright <?=date("Y")?>
</div>



<table id="Table_01" width="1024" height="109" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<img src="<?=$baseurl?>/images/opex_01.jpg" width="15" height="109" alt=""></td>
		<td>

			<img src="<?=$baseurl?>/images/opex_02.jpg" width="281" height="109" alt=""></td>
		<td>
			<img src="<?=$baseurl?>/images/opex_03.jpg" width="358" height="109" alt=""></td>
	  <td width="345" height="109" align="right">
			 <h3>My Account</h3><font color="#FFFFFF">
        <?php
		if ($_SESSION['txb_loggedin']) {
		echo 'Welcome back, '.$_SESSION['displayname'].'.<br />Total Market Value: '.$user['marketvalue'].'<br />Cash for Trading: '.number_format($user['cash'],2).'<br /><a href="login.php?mode=logout">Log Out</a>';
		}
		else {
		echo 'You aren\'t logged in!<br /><a href="login.php">Sign in</a> or <a href="login.php?mode=register">register</a> now to get started.';
		}
		?></font></td>
		<td>
			<img src="<?=$baseurl?>/images/opex_05.jpg" width="25" height="109" alt=""></td>
	</tr>
</table>

<div class="rbroundboxnav">
	<div class="rbtopnav"><div></div></div>
		<div class="rbcontent">
			<p><font size="3" color="#444444">&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$baseurl?>/index.php">OpEx Home</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$baseurl?>/options.php">Exchange Options</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">My Investments</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$baseurl?>/community.php">Community</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$baseurl?>/help">Help</a></font></p>

  </div><!-- /rbcontent -->
	<div class="rbbotnav"><div></div></div>
</div><!-- /rbroundbox -->



    <table>

<tr><td width="1024" height="80%" align="center" valign="top">

<!--Start OpEx Content -->

