<?php
include '../global.php';
            $result = mysql_query("SELECT * FROM holdings WHERE username = '".$_REQUEST['user']."'");
			
			if (mysql_num_rows($result) > 0) {
			echo '<table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="16%" align="center">&nbsp;</td>
    <td width="16%" align="center"><strong>Holding</strong></td>
    <td width="16%" align="center"><strong>Growth</strong></td>
  </tr>';
  }
	while ($hold = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$result2 = mysql_query("SELECT * FROM options WHERE id = '".$hold['option']."'");
	$option = mysql_fetch_array($result2);
	?>
    
    
    
      <tr onmouseover="this.className='border2'" onmouseout="this.className=''" class="">
    <td width="14%"><img src="<?=$option['image']?>" width="35" height="35" border="0" /></td>
    <td width="14%" align="center"><a href="view.php?id=<?=$option['id']?>"><?=$option['name']?>.<?=ucwords($hold['direction'])?></a></td>
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

  </tr>
    


    <?php
	}
	$result2= mysql_query("SELECT cash FROM users WHERE username LIKE '".$_REQUEST['user']."'");
	$usercash = mysql_fetch_row($result2);
	     echo ' <tr onmouseover="this.className=\'border2\'" onmouseout="this.className=\'\'" class="">
    <td><div width="35px" align="center" style="border:1px solid #000;width:35px;"><font size="4">$</font></div></td>
    <td colspan="2" align="center">'.number_format($usercash[0],2).' BandBucks</td>

  </tr>';
	if (mysql_num_rows($result) > 0) {
	echo '</table>';
	}
			?>