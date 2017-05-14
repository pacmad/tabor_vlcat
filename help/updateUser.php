<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update user</title>
<link rel="stylesheet" type="text/css" href="styles/styly.css" />
<script src="scripty/dbConn.js" type="text/javascript"></script>
</head>
<body>
<h1>Update user</h1>
	<form method="post" action="../" id="form_back">
        <input type="hidden" name="name" value="krtek"/>
        <input  type="hidden" name="passwd" value="sauron"/>
        <button type="submit" name="back" id="back"></button>
	</form>
<?php
if ( !isset($_REQUEST['update']) )
{
	?>
    <div id="div_create_new_user">
    
    </div>
	<?php
}
?>
<div id="here_drow"></div>

<script type="text/javascript">
DEF_DIV = 'div_create_new_user';
printUsersToUpdate();
</script>
</body>
</html>
