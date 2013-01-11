<?php
$synergy = 6;
include $adminheader;

?>
<div align="center">
  <h3>OpEx Markets Admin<br>
  Create New Option</h3>
</div>


<?php

include '../global.php';
if ($_REQUEST['mode'] == 'add') {
mysql_query("INSERT INTO pmkt.options SET name = '".$_REQUEST['name']."', detailed = '".$_REQUEST['detailed']."', rules = '".$_REQUEST['rules']."', start = '1', price = '50', outstandinglongs = '".$_REQUEST['shares']."', outstandingshorts = '".$_REQUEST['shares']."', image = '".$_REQUEST['image']."'");

echo '<br /><br /><font size="5" color="#394563">Option Created!</font><br /><br />';
}
?>

<p>Please note: Once this option is created, it will be available for trading immediately.</p>
<form action="newoption.php?mode=add" method="post">
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td>Option Code</td>
    <td><input class="smborder" name="name" type="text" id="name" maxlength="255"> 
      (09.Cavaliers.Win)</td>
  </tr>
  <tr>
    <td>Detailed Name</td>
    <td><input class="smborder" name="detailed" type="text" id="detailed" maxlength="255"> 
      (The Cavaliers will win the 2009....)</td>
  </tr>
  <tr>
    <td valign="top">Rules</td>
    <td valign="top"><textarea class="smborder" name="rules" id="rules" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td>Initial Qty of Shares in each direction</td>
    <td><input class="smborder" name="shares" type="text" id="shares" value="100" maxlength="255"></td>
  </tr>
  <tr>
    <td>Image</td>
    <td><input class="smborder" name="image" type="text" id="image" value="http://" maxlength="255"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input class="smborder" type="submit" name="button" id="button" value="Create Option">
    </div></td>
    </tr>
</table>
</form>
<p>&nbsp;</p>
