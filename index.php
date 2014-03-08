<?php 
	ini_set('display_errors', 'On');

	include_once("controller/Controller.php");

	$controller = new Controller();
	$controller->invoke();

?>