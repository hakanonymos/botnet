<?php
session_start();
include 'includes/config.php';
if (!loggedIn($odb))
{
	header("HTTP/1.1 404 Not Found");
	include_once("includes/404.php");
	die();
}

if (!isset($_GET['p']))
{
	include_once("pages/main.php");
}else{
	$pages = array("main", "bots", "details", "tasks", "settings", "edituser", "users", "logs", "help", "account", "logout");
	$page = $_GET['p'];
	if (in_array($page, $pages))
	{
		include_once("pages/".$page.".php");
	}else{
		header("Location: index.php");
	}
}
?>