<?php
include 'header.php';
?>

<table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="50%" rowspan="3" valign="top"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Most Popular Predictions</h3>
    
       <div class="rbroundbox">
	<div class="rbtop"><div></div></div>
		<div class="rbcontent">
			<p>
            <?php
			$result = mysql_query("SELECT * FROM options WHERE start != '' AND result = '' ORDER BY shares DESC LIMIT 5");
			while ($option = mysql_fetch_array($result, MYSQL_ASSOC)) {
			include 'inc/optionbar.php';

			}
			?>
            <center>[<a href="options.php">view all options</a>]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href="javascript:void(0)" onclick="showPopWin('suggest.php', 400, 400, null);">suggest an option</a>]</center>
            </p>
		</div><!-- /rbcontent -->
	<div class="rbbot"><div></div></div>
</div>
    
    </td>
   <?php
   if ($_SESSION['txb_loggedin']) {
   ?>
    <td valign="top"><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;My Holdings</h3>
    
    <div class="rbroundbox">
	<div class="rbtop"><div></div></div>
		<div class="rbcontent">
			<p><?php
            $result = mysql_query("SELECT * FROM holdings WHERE username LIKE '".$_SESSION['txb_loggedin']."'");
			
			if (mysql_num_rows($result) > 0) {
			echo '<table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="16%" align="center">&nbsp;</td>
    <td width="16%" align="center"><strong>Holding</strong></td>
    <td width="16%" align="center"><strong>Shares</strong></td>
    <td width="16%" align="center"><strong>Growth</strong></td>
	<td width="16%" align="center"><strong>Per Share</strong></td>
    <td width="16%" align="center">&nbsp;</td>
  </tr>';
  }
	while ($hold = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$result2 = mysql_query("SELECT * FROM options WHERE id = '".$hold['option']."'");
	$option = mysql_fetch_array($result2);
	?>
    
    
    
      <tr onmouseover="this.className='border2'" onmouseout="this.className=''" class="">
    <td width="14%"><img src="<?=$option['image']?>" width="35" height="35" border="0" /></td>
    <td width="14%" align="center"><a href="view.php?id=<?=$option['id']?>"><?=$option['name']?>.<?=ucwords($hold['direction'])?></a></td>
    <td width="16%" align="center"><?=$hold['shares']?></td>
    <td width="16%" align="center">  <?php
	  if ($hold['direction'] == 'up') {
    $changeeach = round($option['price'] - $hold['price'],2);
	}
	else if ($hold['direction'] == 'down') {
    $changeeach = round((100-$option['price'])-($hold['price']),2);
	}
	$changeall = round($changeeach * $hold['shares'],2);
	$changepct = round(($changeeach*100)/$hold['price'],2);
	
	
	if ($changepct == 0) {
	  $changecolor = '000000';
	  }
	  else if ($changepct > 0) {
	  $changecolor = '33CC33';
	  }
	  else if ($changepct < 0) {
	  $changecolor = 'FF0000';
	  }
	
	echo '<font color="'.$changecolor.'">'.$changepct.'% ('.$changeall.')</font>';
	?></td>
    <td width="18%" align="center">You Paid: <?=$hold['price']?><br />Current Value: <?=$option['price']?></td>
    <td width="18%" align="center"><div align="center">[<a href="javascript:void(0)" onclick="showPopWin('sell.php?id=<?=$hold['id'] ?>', 400, 400, null);">sell</a>]<br />
      [<a href="javascript:void(0)" onclick="showPopWin('trade.php?id=<?=$option['id'] ?>&direction=<?=$hold['direction']?>', 400, 400, null);">buy more</a>]</div></td>
  </tr>
    
    

    <?php
	}
	if (mysql_num_rows($result) > 0) {
	echo '</table>';
	}
			?></p>
		</div><!-- /rbcontent -->
	<div class="rbbot"><div></div></div>
</div>


</td>
  </tr>
  <tr>
    <td valign="top"><h3>Recent Transactions</h3>
    
        <div class="rbroundbox">
	<div class="rbtop"><div></div></div>
		<div class="rbcontent">
			<p>
            
            
            <?php
			$result = mysql_query("SELECT * FROM transactions WHERE username LIKE '".$_SESSION['txb_loggedin']."' ORDER BY date DESC LIMIT 5");
			
			if (mysql_num_rows($result) == 0) {
			echo 'No recent transactions to display';
			}
			else {
			
			echo '
			<a href="javascript:void(0)" onclick="showPopWin(\'transaction.php\', 400, 400, null);">view all transactions</a>
			<br />
			<table width="100%" border="0" cellspacing="0">';


			while ($tact = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$date = explode(" ",$tact['date']);
			$date = explode('-',$date[0]);
	
			
			echo '<tr onmouseover="this.className=\'border2\'" onmouseout="this.className=\'\'" class="">
			<td width="20%">'.$date[1].'-'.$date[2].'-'.$date[0].'</td>
			<td>'.$tact['description'].'</td>
			<td width="10%"><img src="images/'.$tact['type'].'.gif"></td>
			<td width="10%">'.number_format($tact['amount'],2).'</td>			
			<td align="right">[<a href="javascript:void(0)" onclick="showPopWin(\'transaction.php?id='.$tact['id'].'\', 400, 400, null);">details</a>]</td>
</tr>';
			}


			echo '</table>';

			
			}
			?>
            
            </p>
		</div><!-- /rbcontent -->
	<div class="rbbot"><div></div></div>
</div>
    
    </td>
  </tr>
  <?php } ?>
  <tr>
    <td valign="top"><h3>About</h3>
    
        <div class="rbroundbox">
	<div class="rbtop"><div></div></div>
		<div class="rbcontent">
			<p>Include copy with introduction, help, register, and login links.</p>
		</div><!-- /rbcontent -->
	<div class="rbbot"><div></div></div>
</div>
    
    </td>
  </tr>
</table>
<?php
include 'footer.php';
?>
