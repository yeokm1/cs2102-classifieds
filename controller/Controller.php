<?php
	include_once("model/Model.php");
	
	class Controller {
		public $model;
		
		public function __construct() {  
			$this->model = new Model();

		} 
		public function invoke() {
			if(!isset($_SESSION)) {
				session_start();
			}

			if(isset($_GET['action'])) {
					$this->handle_action();
			}
			else
			{
				if (!isset($_SESSION['username'])) {
					//show login page.
					$this->handle_login();
				} else {
					//show main page.
					$this->handle_main();
				}
			}
		}
		
		function handle_action() {
			
		}
		
		function handle_login() {
		
		}
		
		function handle_main() {
		
		}
	}
?>