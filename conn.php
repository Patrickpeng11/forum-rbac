<?php


/*Connect the Database*/

session_start();
error_reporting(E_ALL^E_NOTICE);

$link = mysqli_connect("localhost", "root", "", "chat");

// error output the notice
if (!$link) {
	die('failed to connect the database');
}

$userinfo = array();
if (!empty($_SESSION['userid'])) {
	$sql = "select * from users where id='$_SESSION[userid]'";
	$query_id = mysqli_query($link, $sql);
	$userinfo = mysqli_fetch_assoc($query_id);
}

?>