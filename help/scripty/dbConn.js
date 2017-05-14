// JavaScript Document


/**
* Prints comments
* @param where	id of div, where comments will be printed
* @param table	SQL table where are comments
* @param n		name of user
*/
function printComm( where, table, n )
{
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "help/scripty/printComm.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + table + "&n=" + n );
}


/**
* Delete comment
* @param id		id of comment
* @param where	id of div, where rest comments will be printed
* @param table	SQL table where are comments
* @param n		name of user
*/
function delComm( id, where, table, n )
{
	var enter = confirm( "Opravdu chceš smazat komentář?" );
	if ( !enter ) return;
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open( "POST", "help/scripty/delComm.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id=" + id + "&table=" + table );
	
	printComm( where, table, n );
}

/**
* Create comment
* @param where		id of div, where rest comments will be printed
* @param table		SQL table where are comments
* @param n			name of user
* @param ip			IP address of user
* @param DEFF_MESS	default message inserted by system like 'here write comment'
*/
function insertComm( where, table, n, ip, DEFF_MESS )
{
	var subj = document.getElementById( 'subject' ).value;
	var comm = document.getElementById( 'textarea' ).value;
	if ( comm == '' || comm == DEFF_MESS )
	{
		alert( 'Nevyplněné povinné pole' );
		return;
	}
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open( "POST", "help/scripty/insertComm.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "table=" + table + "&name=" + n + "&ip=" + ip + "&subject=" + subj + "&comm=" + comm );
	
	printComm( where, table, n );
	
	var subj = document.getElementById( 'subject' ).value = '';
	var comm = document.getElementById( 'textarea' ).value = '';
}

function showFormToUpdate( whereToGetID, whereToDrow ) {
	var e = document.getElementById( whereToGetID );
	var id = e.options[e.selectedIndex].value;
	if ( id == 0 ) {
		document.getElementById( whereToDrow ).innerHTML = "";
		return;
	}
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( whereToDrow ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/formToUpdatePerson.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id=" + id );
}
function printUsersToUpdate(){
	
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest();
	} else {
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( DEF_DIV ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "scripty/selectPersonFromList.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}
