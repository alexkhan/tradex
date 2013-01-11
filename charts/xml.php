<chart caption='Historical Price' subcaption='' xAxisName='Date' yAxisName='Price' numberPrefix='$' showNames='1' showValues='0' rotateNames='0' showColumnShadow='1' animation='1' showAlternateHGridColor='1' AlternateHGridColor='ff5904' divLineColor='444444' divLineAlpha='20' alternateHGridAlpha='5' canvasBorderColor='666666' baseFontColor='666666' lineColor='B30004' lineAlpha='85'>
<?php
include '../global.php';
$result = mysql_query("SELECT * FROM pmkt.historical WHERE `option` = '".$_REQUEST['id']."'");
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$date = explode(" ",$row['date']);
	$date = explode("-",$date[0]);
	if ($date[1] < 10) {
	$date[1] = $date[1][1];
	}
	if ($date[2] < 10) {
	$date[2] = $date[2][1];
	}
	$date = $date[1]."/".$date[2];
echo "<set label='$date' value='".$row['closeprice']."' />\n";
}
?>
</chart>