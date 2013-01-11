<?php
	$result = mysql_query("SELECT * FROM `historical` WHERE `option` = '".$option['id']."' AND date LIKE '$today%'");
	if (mysql_num_rows($result) == 0) {
	mysql_query("INSERT INTO historical SET `option` = '".$option['id']."', closeprice = '$newprice', date = NOW()");
	}
	else {
	mysql_query("UPDATE historical SET closeprice = '$newprice' WHERE `option` = '".$option['id']."' AND date LIKE '$today%'");
	}
?>