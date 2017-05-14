<?php
$telefon = $_REQUEST['telefon'] == "" ? NULL : $_REQUEST['telefon'];
$statement1 = "UPDATE vlc_users SET name='".$_REQUEST['name']."', sname='".$_REQUEST['sname']."', nick='".$_REQUEST['nick']."', nickname='".$_REQUEST['nickname']."', passwd='".$_REQUEST['passwd']."', mail='".$_REQUEST['mail']."', platnost=".$_REQUEST['platnost'].", etapa=".$_REQUEST['etapa'].", aktivni=".$_REQUEST['aktivni'].", kuchar=".$_REQUEST['kuchar'].", admin=".$_REQUEST['admin'].", telefon='".$telefon."' WHERE id='".$_REQUEST['id']."' );";
//$statement2 = "INSERT INTO vlc_last_log ( nick, mail ) VALUES ( '".$_REQUEST['nick']."', '".$_REQUEST['mail']."' );";


$promenne = '../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		if ( $spojeni->query( $statement1 ) )
		{
			$subject = 'Účet aktualizován na 51. smečce Vlčat';
			$message = 'Byl Vám změněn účet na http://vlcata.pohrebnisluzbazlin.cz.

Přihlašovací jméno: '.$_REQUEST['nick'].'
Heslo: '.$_REQUEST['passwd'].'

S případnými dotazy se obraťte na správce webu ('.$spravce.')';
			$headers = 'From: Vlčata <'.$spravce.'>';
			mail( $_REQUEST['mail'], $subject, $message, $headers );
			echo '<p>Everything gone OK <br />'.$statement1.'<br />Mail sent to '.$_REQUEST['mail'].'</p>';
		}
		else echo '<p>Statement contain mistake<br /><br />'.$statement1.'</p>';
		//if ( $spojeni->query( $statement2 ) ) echo $statement2;
		//else echo '<p>Statement contain mistake<br /><br />'.$statement2.'</p>';
		
	}
	else echo "<p>Connection with database had failed.</p>";
}
else echo "<p>File $promenne doesn't exists.</p>";
?>