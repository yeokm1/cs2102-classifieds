<?php 
	ini_set('display_errors', 'On');

	include_once("controller/ControllerAdmin.php");

	$controller = new ControllerAdmin();
	$controller->invoke();

?>