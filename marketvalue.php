<?php

include 'global.php';
if (!$_SESSION['txb_loggedin']) {
$result = mysql_query("SELECT * FROM users");
}
else {
$result = mysql_query("SELECT * FROM users WHERE username LIKE '".$_SESSION['txb_loggedin']."'");
}
	while ($user = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$marketval = 0;
		$result2 = mysql_query("SELECT * FROM `holdings` WHERE username LIKE '".$user['username']."'");
			while ($holding = mysql_fetch_array($result2)) {
				
				$result3 = mysql_query("SELECT price FROM `options` WHERE id = '".$holding['option']."'");
				$price = mysql_fetch_row($result3);
				if ($holding['direction'] == 'up') {
				$marketval = $marketval + ($holding['shares'] * $price[0]);
				}
				else if ($holding['direction'] == 'down') {
				$marketval = $marketval + ($holding['shares'] * (100-$price[0]));
				}
				
				
			}
			
			if (!strstr($user['lasthupdate'],$today)) {
			$addonsql = ", h1 = '$marketval', h2 = '".$user['h1']."', h3 = '".$user['h2']."', h4 = '".$user['h3']."', h5 = '".$user['h4']."', h6 = '".$user['h5']."', h7 = '".$user['h6']."', lasthupdate = NOW()";
			}
			else {
				$addonsql = "";
			}
			
			
			mysql_query("UPDATE users SET marketvalue = '$marketval', lasttrade = NOW()$addonsql WHERE id = '".$user['id']."'");
			
			
	}


?>