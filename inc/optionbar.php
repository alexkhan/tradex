<table width="100%" border="0" cellspacing="0" bgcolor="#CCCCCC" style="border-width: 1px; border-style: none; border-bottom-style:dashed; border-color: #666666;<? if ($sub) { echo ' border-style: dashed;'; } ?>">
  <tr>
    <td width="100" height="100" rowspan="2" align="center" valign="middle"><img src="<?=$option['image']?>" width="50" height="50" border="0" /></td>
    <td><div align="center"><strong>
     <?php if (!$viewpg) { ?> <a href="view.php?id=<?=$option['id']?>"><?php } echo $option['detailed']; if (!$viewpg) { ?></a><?php } ?>
    </strong></div></td>
    <td rowspan="2" width="100"><div align="center"><font size="4"><strong>
      <?=substr($option['price'],0,5)?>%</strong></font><br />
      
      <?
	  $result3 = mysql_query("SELECT closeprice FROM historical WHERE `option` = '".$option['id']."' AND date NOT LIKE '$today%' ORDER BY date DESC LIMIT 1");
	  $oldprice = mysql_fetch_row($result3);
	  if (!$oldprice[0]) {
	  $oldprice[0] = 50;
	  }
	  $change = $option['price'] - $oldprice[0];
	  $changepct = substr(($change*100)/$oldprice[0],0,5);
	  
	  if ($change == 0) {
	  $changecolor = '000000';
	  }
	  else if ($change > 0) {
	  $changecolor = '33CC33';
	  }
	  else if ($change < 0) {
	  $changecolor = 'FF0000';
	  }
	  if ($change > 0) {
	  $change = '+'.$change;
	  $changepct = '+'.$changepct;
	  }
	  echo '<font color="#'.$changecolor.'">'.substr($change,0,5).' ('.$changepct.'%)</font>';
	  ?>
      
      <br />
    </div></td>
  </tr>
  <tr>
    <td><div align="center">Think the chance of this is higher or lower?<br />
      <input type="submit" name="button2" id="button2" value="Higher" style="border:1px solid #FFFFFF; color: #FFFFFF; font-size: 11px; font-family: Arial; background-color: #CC3300; background-color:#339900" onclick="showPopWin('trade.php?id=<?=$option['id'] ?>&direction=up', 400, 400, null);" />
      <input type="submit" name="button2" id="button2" value="Lower" style="border:1px solid #FFFFFF; color: #FFFFFF; font-size: 11px; font-family: Arial; background-color: #CC3300; background-color:#A10506;" onclick="showPopWin('trade.php?id=<?=$option['id'] ?>&direction=down', 400, 400, null);" />
        <br />
    </div></td>
  </tr>
</table>
