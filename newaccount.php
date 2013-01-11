<?php
include 'header.php';
if (!$_SESSION['newaccount']) {
header("Location: index.php");
}
else {
?>

<h3>Welcome to OpEx!</h3> 
<div align="left" style="background-color:#FFF">
<p>Include new user registration copy here</p>
<p><br />
  <br />
</p>
<p><strong>Get Started</strong> - sometimes the best way to learn something is just to play around with it. If you'd like you can click on the &quot;<a href="index.php">OpEx Home</a>&quot; link at the top of this page and jump right in. Don't worry... if you make mistakes, you can always reset your account.</p>
</p>
</div>
<p>&nbsp;</p>
<?php

}
include 'footer.php';
?>
