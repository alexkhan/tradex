<html><head>
<style>
html, body {
height: 100%;
}
body,td,th {

	/*font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10pt;
	*/
	font-family:"lucida grande", tahoma, verdana, arial, sans-serif;
	font-size:11px;
	color: #000;
}
.border {
	background-color: CACACA;
	border-width: 1px; 
	border-style: solid; 
	border-color: 666666; 
}
.border2 {
	background-color: #999999;
	border-width: 1px; 
	border-style: dashed; 
	border-color: 666666; 
}
.smborder {
	background-color: #FFF;
	border-width: 1px; 
	border-style: solid; 
	border-color: 666666;
	font-family:"lucida grande", tahoma, verdana, arial, sans-serif;
	font-size:11px;
}
.smborder2 {
	background-color: #FFF;
	border-width: 1px; 
	border-style: dashed; 
	border-color: 666666;
	font-family:Arial, Helvetica, sans-serif;
	font-size:8px;
}
h3 {
color: #A10606;
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:18px;
}
a:link {
	color: #A10606;
}
a:visited {
	color: #A10606;
}
a:hover {
	color:#FF3300;
}
a:active {
	color: #A10606;
}
/* set millions of background images */
.rbroundbox { background: url(images/nt.gif) repeat; }
.rbtop div { background: url(images/tl.gif) no-repeat top left; }
.rbtop { background: url(images/tr.gif) no-repeat top right; }
.rbbot div { background: url(images/bl.gif) no-repeat bottom left; }
.rbbot { background: url(images/br.gif) no-repeat bottom right; }

/* height and width stuff, width not really nessisary. */
.rbtop div, .rbtop, .rbbot div, .rbbot {
width: 100%;
height: 7px;
font-size: 1px;
}
.rbcontent { margin: 0 7px; }
.rbroundbox { width: 90%; margin: 1em auto; }
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image:url(images/modalheader.jpg);
	background-repeat:repeat-x;
}
</style></head>

<body>

<table width="100%" height="100"><tr><td></td></tr></table>

<br />
<div align="center">
  <p><b>Suggest New Options</b><br />
    <br />
    <?php
	if ($_REQUEST['op'] == 'submit') {
	mail ($supportemail,"Suggestions",$_REQUEST['text']);
	echo '<br /><br /><br />Thank you for your suggestions!';
	}
	else {
	?>
    OpEx takes suggestions from users for new options to trade.<br>
  Please provide any suggestions below!</p>
  <form name="form1" method="post" action="?op=submit">
    <textarea name="text" cols="45" rows="7" class="smborder" id="text"></textarea>
    <br>
    <input name="button" type="submit" class="smborder" id="button" value="Submit">
  </form>
  <p><br />
    </p>
    <?php } ?>
</div>
</body>
</html>
