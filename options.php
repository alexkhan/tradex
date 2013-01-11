<?php
include 'header.php';

$resultfilter = mysql_query("SELECT category FROM options WHERE start != '' AND result = '' ORDER BY category");
$lastfilter = "";
echo '<script language="JavaScript">
function goto(form) { var index=form.select.selectedIndex
if (form.select.options[index].value != "0") {
location=form.select.options[index].value;}}
//-->
</SCRIPT>
<form name="Opex_NAV"><SELECT NAME="select" ONCHANGE="goto(this.form)" SIZE="1">
<option>select a category</option>
<option disabled="disabled">--------</option>
';
while ($filter = mysql_fetch_array($resultfilter, MYSQL_ASSOC)) {

	if ($filter['category'] != $lastfilter) {
	$lastfilter = $filter['category'];
	echo '<option value="'.$baseurl.'/options.php?sort='.$filter['category'].'">'.$filter['category'].'</option>';
	}

}
echo '<option disabled="disabled">--------</option>
<option value="'.$baseurl.'/options.php?expired=expired">Expired Options (view only)</option>
</select></form>';

echo '<table width="100%" border="0" cellspacing="0">';
if ($_REQUEST['sort']) {
$sortadd = " AND category = '".$_REQUEST['sort']."'";
}
	$result = mysql_query("SELECT * FROM options WHERE start != '' AND result = ''$sortadd");
	
	if ($_REQUEST['expired']) {
	$result = mysql_query("SELECT * FROM options WHERE start != '' AND result != ''");
	}
	while ($option = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if (!$opt || $opt > 3) {
		$opt = 1;
		}
		if ($opt == 1) {
		echo '<tr><td>';
		}
		else {
		echo '<td>';
		}
		$sub = true;
	include 'inc/optionbar.php';
		if ($opt == 3) {
		echo '</td></tr>';
		}
		else {
		echo '</td>';
		}	
		$opt++;
		
	}
	echo '</table>';
include 'footer.php';
?>
