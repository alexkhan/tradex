<?php
$synergy = 6;
include $adminheader;

?>
<div align="center"><h3>OpEx Markets Admin</h3></div>

<table width="100%" border="0" cellspacing="0">
  <tr>
    <td valign="top"><p><strong>Options</strong></p>
    <p>[<a href="newoption.php">add new option</a>]</p>
    <p>
<form action="expire.php" method="post">
    <select name="id" id="id" class="smborder">
      
   
    <?php
include '../global.php';
	$result = mysql_query("SELECT * FROM pmkt.options WHERE result = ''");
	while ($option = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo '<option value="'.$option['id'].'">'.$option['name'].'</option>';
	}
	?>
    
     </select><input type="submit" name="submit" value="Expire Option" class="smborder" /></form>
    </p></td>
    <td valign="top"><p><strong>Users</strong></p>
    <p>
    <form action="users.php" method="post">
    <input class="smborder" type="text" name="username" id="username" />
    <input class="smborder" type="submit" name="submit" value="Find" />
    </form>
    
    </p></td>
  </tr>
</table>
