<?php

function toDefaultTime( $in )
{
	$date = explode( ' ', $in );
	if ( count($date) == 1 ) return $in;
	$time = explode( ':', $date[1] );
	
	return $date[0].'T'.$time[0].':'.$time[1];
}
function toSQLTime( $in )
{
	$date = explode( 'T', $in );
	return $date[0].' '.$date[1];
}

	
$warning1 = false;
$warning2 = false;
$warning3 = false;
$item_nahran = false;
if (isset($_REQUEST['nahrat']) && $_REQUEST['nahr_nazev'] == '') $warning1 = true;
if (isset($_REQUEST['nahrat']) && $_REQUEST['nahr_cena'] == '') $warning2 = true;
if (isset($_REQUEST['nahr_cena']) && !$warning2 && !is_numeric($_REQUEST['nahr_cena'])) $warning3 = true;
if (isset($_REQUEST['nahrat']) && !$warning1 && !$warning2 && !$warning3) $item_nahran = true;
?>
<h1>Přidat položku do databáze</h1>
<div id="right">
    <form method="post" action="">
        <input name="jmeno" value="<?php echo $login;?>" type="hidden" />
        <input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
        <input type="hidden" name="sekce" value="uvod" />
        <button type="submit" name="back" class="menu">Zpět na inventář</button>
    </form>
</div>
	
<div id="add_form">
<?php 
$sql = $spojeni->query( "SELECT * FROM utrata_".$name." WHERE id = (SELECT max(id) FROM utrata_".$name.")" );
$last = mysqli_fetch_array( $sql );
    
    
if ( !$item_nahran || ($last['nazev'] == $_REQUEST['nahr_nazev'] && $last['popis'] == $_REQUEST['nahr_popis'] && $last['cena'] == $_REQUEST['nahr_cena'] && $last['pozn'] == $_REQUEST['nahr_pozn'] && $last['datum'] == toSQLTime($_REQUEST['datum']) && $last['typ'] == $_REQUEST['nahr_typ']) )
{ 
    require( 'getMyTime().php' );
    ?>
    <form method="post">
        <p><label> Název:<strong class="red">*</strong> <input class="ins" name="nahr_nazev" value="<?php if (isset($_REQUEST['nahr_nazev'])) echo $_REQUEST['nahr_nazev'];?>" /></label></p><br />
        <p id="napoveda"><?php for ($i=0;$i<20;$i++) echo "&nbsp;"?><span onClick="klik('odepsat')">Odepsat</span>
                         <?php for ($i=0;$i<5;$i++) echo "&nbsp;"?><span onClick="klik('výběr')">Výběr</span></p>
                 <script type="text/javascript">
                    function klik(e){
						var classes = $(".ins");
						for ( var i = 0; i < classes.length; i++ ) {
							classes[i].value = e;
						}
                    };
                 </script>
        <p><label>Popis: <textarea class="ins" name="nahr_popis" rows="1"><?php if (isset($_REQUEST['nahr_popis'])) echo $_REQUEST['nahr_popis'];?></textarea></label></p><br />
        <p>Poznámka: <select name="nahr_pozn" size="1">
            <option value="jidlo" <?php if (isset($_REQUEST['nahr_pozn']) && $_REQUEST['nahr_pozn'] == 'jidlo') echo 'selected="selected"';?>>Jídlo</option>
            <option value="transport" <?php if (isset($_REQUEST['nahr_pozn']) && $_REQUEST['nahr_pozn'] == 'transport') echo 'selected="selected"';?>>Transport</option>
            <option value="kosmetika" <?php if (isset($_REQUEST['nahr_pozn']) && $_REQUEST['nahr_pozn'] == 'kosmetika') echo 'selected="selected"';?>>Kosmetika</option>
            <option value="leky" <?php if (isset($_REQUEST['nahr_pozn']) && $_REQUEST['nahr_pozn'] == 'leky') echo 'selected="selected"';?>>Léky</option>
            <option value="ostatni" <?php if (isset($_REQUEST['nahr_pozn']) && $_REQUEST['nahr_pozn'] == 'ostatni') echo 'selected="selected"';?>>Ostatní</option>
        </select></p><br />
        <p>Typ platby: <select name="nahr_typ" rows="1">
            <option value="karta" <?php if (isset($_REQUEST['nahr_typ']) && $_REQUEST['nahr_typ'] == 'karta') echo 'selected="selected"';?>>Karta</option>
            <option value="hotovost" <?php if (isset($_REQUEST['nahr_typ']) && $_REQUEST['nahr_typ'] == 'hotovost') echo 'selected="selected"';?>>Hotovost</option>
        </select></p><br />
        <p>Datum: <input type="datetime-local" name="datum" value="<?php echo toDefaultTime( getMyTime() ); ?>" />
        </p><br />
        <p><label> Cena:<strong class="red">*</strong> <input type="number" step="0.01" id="cena" name="nahr_cena" value="<?php if (isset($_REQUEST['nahr_cena'])) echo $_REQUEST['nahr_cena'];?>" /> <?php echo $currency; ?></label></p><br />
        <input name="jmeno" value="<?php echo $login; ?>" type="hidden" />
        <input name="heslo" value="<?php echo $passwd; ?>" type="hidden" />
        <input type="hidden" name="sekce" value="pridat" />
        <button typename="nahrat" name="nahrat">Nahrát</button> <em class="red">*Povinné pole</em></p><br />
    </form>
    <?php
    if ($warning1) echo ' <strong class="red">Vyplň název</strong><br />';
    if ($warning2) echo ' <strong class="red">Vyplň cenu</strong><br />';
    if ($warning3) echo ' <strong class="red">Cena není číslo</strong><br />';
    if (isset($_REQUEST['nahrat']) && strpos($_REQUEST['nahr_cena'],',') !== false) {?><em class="pozn">Pro oddělení haléřů použij desetinnou tečku</em><br /><?php }
}
else //item nahrán
{
    require("getMyTime().php");

    setlocale(LC_ALL, 'czech');
    $nazev = strtolower(preg_replace('/[^a-zA-Z0-9.]/','',iconv('UTF-8', 'ASCII//TRANSLIT', $_REQUEST['nahr_nazev'])));
    $popis = strtolower(preg_replace('/[^a-zA-Z0-9.]/','',iconv('UTF-8', 'ASCII//TRANSLIT', $_REQUEST['nahr_popis'])));
	
    if ( strpos($nazev, 'vyber') !== false || strpos($popis, 'vyber') !== false)
    {
		$spojeni->query("INSERT INTO utrata_".$name." (nazev, popis, cena, pozn, datum, typ) VALUES ('".$_REQUEST['nahr_nazev']."', '".$_REQUEST['nahr_popis']."', '".$_REQUEST['nahr_cena']."', 'ostatni', '".toSQLTime( $_REQUEST['datum'] )."', 'karta')");
		
		$sql = $spojeni->query( "SELECT max(id) MAX FROM utrata_".$name );
		$max = mysqli_fetch_array( $sql );
        $spojeni->query("INSERT INTO utrata_akt_hodnota_".$name." (datum, hodnota, typ, duvod, idToDelete) VALUES ('".toSQLTime( $_REQUEST['datum'] )."', '".$_REQUEST['nahr_cena']."', 'hotovost', 'Výběr', ".$max['MAX'].")");
    }
    else
    {
		$spojeni->query("INSERT INTO utrata_".$name." (nazev, popis, cena, pozn, datum, typ) VALUES ('".$_REQUEST['nahr_nazev']."', '".$_REQUEST['nahr_popis']."', '".$_REQUEST['nahr_cena']."', '".$_REQUEST['nahr_pozn']."', '".toSQLTime( $_REQUEST['datum'] )."', '".$_REQUEST['nahr_typ']."')");
		
        $mailphp = 'together/mail.php';
        if ( file_exists($mailphp) && require($mailphp) )
        {
            if ( $sendByOne )
            {
                $to = $mother;
                $subject = 'Další '.$name.'\'s útrata';
                $message = '
                Název: '.$_REQUEST['nahr_nazev'].'
                Poopis: '.$_REQUEST['nahr_popis'].'
                Typ: '.$_REQUEST['nahr_pozn'].'
                Cena: '.$_REQUEST['nahr_cena'].' '.$currency.'
                
                ('.dateToReadableFormat( getMyTime() ).')
                http://vlcata.pohrebnisluzbazlin.cz/index.php';
                $headers = 'From: utrata <'.$spravce.'>\n';
                
                my_mail($to, $subject, $message, $headers);
            }
        }
        else echo 'Soubor mail.php se nepodařilo najít.';
    }
    echo '<p>Položka byla nahrána do databáze.</p>';
    ?>
        <form method="post" action="">
            <input name="jmeno" value="<?php echo $login;?>" type="hidden" />
            <input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
            <input type="hidden" name="sekce" value="pridat" />
            <button type="submit" name="dalsi" class="menu">Přidal talší položku</button>
        </form>
    <?php
	
	echo '</div>';
}
?>