<?php
$table = $_REQUEST['table'];
$file_id = $_REQUEST['file_id'];
$userName = $_REQUEST['userName'];
$tableSeen = $_REQUEST['table_seen'];

if ( file_exists( "../../promenne.php" ) && require( "../../promenne.php" ) )
{
	if ( ($spojeni = mysqli_connect($db_host, $db_username, $db_password, $db_name)) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$sql = $spojeni->query( "SELECT * FROM ".$table." WHERE id = ".$file_id );
		$polozka = mysqli_fetch_array( $sql );
		$spojeni->query( "UPDATE ".$table." SET seen = ".(++$polozka['seen'])." WHERE id = ".$file_id );
		echo "UPDATE ".$table." SET seen = ".($polozka['seen'])." WHERE id = ".$file_id."<br />";
		
		if ( file_exists("../../getMyTime().php") ) {
			require("../../getMyTime().php");
			$spojeni->query( "INSERT INTO ".$tableSeen." ( user, file, date ) VALUES ( '".IDFromNick( $userName, $spojeni )."', '".$file_id."', '".getMyTime()."' ) " );
			echo "INSERT INTO ".$tableSeen." ( user, file, date ) VALUES ( '".IDFromNick( $userName, $spojeni )."', '".$file_id."', '".getMyTime()."' ) ";
		} else echo __DIR__."../../getMyTime.php ne-e.";
	}
}
?>