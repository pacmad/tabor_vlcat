<?php 

$db_host = 'localhost';
$db_username = 'root';
$db_password = 'ahoj';
$db_name = 'vlc_login_users';

$spravce = 'krtek@zlin6.cz';



function toHacky( $in, & $spojeni )
{
	$tmp = $spojeni->query( "SELECT nickname RES FROM vlc_users WHERE nick = '".$in."'" );
	$tmp = mysqli_fetch_array( $tmp );
	return $tmp['RES'] == '' ? $in : $tmp['RES'];
}
function nicknameFromID( $in, & $spojeni )
{
	$tmp = $spojeni->query( "SELECT nickname RES FROM vlc_users WHERE id = '".$in."'" );
	$tmp = mysqli_fetch_array( $tmp );
	return $tmp['RES'] == '' ? $in : $tmp['RES'];
}
function IDFromNick( $in, & $spojeni )
{
	$tmp = $spojeni->query( "SELECT id RES FROM vlc_users WHERE nick = '".$in."'" );
	$tmp = mysqli_fetch_array( $tmp );
	return $tmp['RES'] == '' ? $in : $tmp['RES'];
}

function dateToReadableFormat( $date )
{
	if ( $date == '0' ) return $date;
	
	list( $date, $time ) = explode( ' ', $date );
	list( $year, $month, $day ) = explode( '-', $date );
	$months = array( 'leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec' );
	$month = $month == '01' ? $months[0] : ( $month == '02' ? $months[1] : ( $month == '03' ? $months[2] : ( $month == '04' ? $months[3] : ( $month == '05' ? $months[4] : ( $month == '06' ? $months[5] : ( $month == '07' ? $months[6] : ( $month == '08' ? $months[7] : ( $month == '09' ? $months[8] : ( $month == '10' ? $months[9] : ( $month == '11' ? $months[10] : ( $months[11] )))))))))));
	return $day.'. '.$month.' '.$year.' | '.$time;
}

function isAdmin( $name, & $spojeni )
{
	$sql = $spojeni->query( "SELECT * FROM vlc_users WHERE nick = '".$name."'" );
	$person = mysqli_fetch_array( $sql );
	return $person['admin'] == 1 ? true : false;
}
/*
$db_host = 'wm70.wedos.net';
$db_username = 'w79175_vlcata';
$db_password = '7hP874ML';
$db_name = 'd79175_vlcata';


//plný přístup:
$db_username = 'a79175_vlcata';
$db_password = 'RkAmcKJb';

/*

Databázový server: wm70.wedos.net
Název databáze: d79175_vlcata

Uživatel pro správu databáze (má plná přístupová práva):
Jméno: a79175_vlcata
Heslo: RkAmcKJb

Uživatel s omezenými právy pro použití ve vašich skriptech:
Jméno: w79175_vlcata
Heslo: 7hP874ML


FTP:
Server: 79175.w75.wedos.net
Login: w79175_krtek
Heslo: sefFU6eh
*/
?>