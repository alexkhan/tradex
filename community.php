<?php
include 'header.php';
?>
 <script type="text/javascript" src="/js/ajax.js"></script> 
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="50%" rowspan="3" valign="top"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Top Portfolios</h3>
    
       <div class="rbroundbox">
	<div class="rbtop"><div></div></div>
		<div class="rbcontent">
			<p>
            <table width="100%">
            <?php
			$result = mysql_query("SELECT * FROM users WHERE displayname != '' ORDER BY cash DESC LIMIT 35");
			while ($user = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "<tr><td width='50%'><a href=\"javascript:void(0);\" onclick=\"getdata('inc/portfolio.php?user=".$user['username']."','default');\">".$user['displayname']."</a></td><td>".number_format($user['marketvalue']+$user['cash'],2)."</td></tr>";
			}
			?></table>
            </p>
		</div><!-- /rbcontent -->
	<div class="rbbot"><div></div></div>
</div>
    
    </td>

  <tr>
    <td valign="top"><h3>Portfolio Holdings</h3>
    
        <div class="rbroundbox">
	<div class="rbtop"><div></div></div>
	<div class="rbcontent"><p>
    
<div id="default">Click a username on the left side to view what options they have in their portfolio.<br />
<br />
Users are sorted by only the value of their holdings, but the number displayed is the sum of holdings and cash.</div>
    
    </p></div><!-- /rbcontent -->
	<div class="rbbot"><div></div></div>
</div>
    
    </td>
  </tr>
</table>
<?php
include 'footer.php';
?>
