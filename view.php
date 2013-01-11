<?php
$viewpg = true;
include 'header.php';
$result = mysql_query("SELECT * FROM `pmkt`.`options` WHERE id = '".$_REQUEST['id']."'");

$option = mysql_fetch_array($result);
	echo '<table width="60%"><tr width="60%"><td width="60%">';															
include 'inc/optionbar.php';
echo '</td></tr></table>'; ?>
<script language="JavaScript" src="charts/charts.js"></script>
<script language="JavaScript">
function FC_Rendered(DOMId){
	//remove Message
	var divRef = document.getElementById("unableDiv");
	divRef.style.display='none';

}
</script>
<style>
#holder {
	overflow: auto;
	float: left;
	padding: 0.5em;
	margin-left: 10px;
	width: 450px;
	height: 270px;
	margin-top: 3px;
	font-family:"lucida grande", tahoma, verdana, arial, sans-serif;
	font-size:11px;

}

</style>
<table width="100%" border="0">
  <tr>
    <td width="50%" valign="top"><h3>Discussion</h3>
    <div id="holder">
   
    
    <?php
	if ($_SESSION['txb_loggedin'] && $_REQUEST['mode'] == 'comment') {
		$result = mysql_query("INSERT INTO pmkt.discussion SET `option` = '".$_REQUEST['id']."', username = '".$_SESSION['displayname']."', text = '".strip_tags($_REQUEST['text'])."', date = NOW()");
		header("Location: view.php?id=".$_REQUEST['id']);
	}
	$result = mysql_query("SELECT * FROM pmkt.discussion WHERE `option` = '".$_REQUEST['id']."' ORDER BY date DESC");
    while ($post = mysql_fetch_array($result,MYSQL_ASSOC)) {
		echo '<hr /><strong>'.$post['username'].'</strong> '.$post['text'];
	}
	?> 
    </div>
    <?php
	if ($_SESSION['txb_loggedin']) { ?>
    <h3>Join the Discussion</h3>
    <form action="view.php?id=<?=$_REQUEST['id']?>&mode=comment" method="post">
      <input name="text" type="text" id="text" size="60" maxlength="250" class="smborder" />
      <input type="submit" name="Submit" id="button" value="Add Comment" class="smborder" />
      <br />
</form><?php } ?>

    </td>
    <td valign="top"><h3>Historical Prices</h3><div id="chart1div"><noscript>
	<!-- START Code Block for Chart sampleChart -->
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="500" height="300" id="sampleChart">
		<param name="allowScriptAccess" value="always" />
		<param name="movie" value="charts/Line.swf"/>		
		<param name="FlashVars" value="&chartWidth=500&chartHeight=300&debugMode=0&dataURL=charts/xml.php?id=<?=$_REQUEST['id']?>" />
		<param name="quality" value="high" />
		<embed src="charts/Line.swf" FlashVars="&chartWidth=500&chartHeight=300&debugMode=0&dataURL=charts/xml.php?id=<?=$_REQUEST['id']?>" quality="high" width="500" height="300" name="sampleChart" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
	<!-- END Code Block for Chart sampleChart -->
	</noscript>
		  <p>&nbsp;</p>
		  <p>FusionCharts needs Adobe Flash Player to run. If you're unable to see the chart here, it means that your browser does not seem to have the Flash Player Installed. You can downloaded it <a href="http://www.adobe.com/products/flashplayer/" target="_blank"><u>here</u></a> for free.</p>

		</div>
		<script type="text/javascript">
		   var chart1 = new FusionCharts("charts/Line.swf", "sampleChart", "500", "300", "0", "1");
		   chart1.setDataURL("charts/xml.php?id=<?=$_REQUEST['id']?>");	   
		   
		   chart1.render("chart1div");
		</script></div>
</td>
  </tr>
</table>
</center>
<?php
include 'footer.php';
?>
