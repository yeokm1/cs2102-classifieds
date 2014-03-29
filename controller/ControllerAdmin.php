<?php
	include_once("model/ModelAdmin.php");
	
	class ControllerAdmin {
		public $m_adm;
		
		public function __construct() {
			$this->m_adm = new ModelAdmin();
		} 
		public function invoke() {
			if(!isset($_SESSION)) {
				session_start();
			}
			if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
			//	header('HTTP/1.0 403 Forbidden'):
				header('Location: index.php');
				exit;
			}

			if(isset($_GET['action'])) {
					$this->handle_action();
			}
			else {
				$this -> handle_summary();
			}
		}
		
		function handle_action() {
			if($_GET['action'] == "classifieds") {
				$this -> handle_classifieds();
			} else if($_GET['action'] == "users") {
				$this -> handle_users();
			} else if($_GET['action'] == "categories") {
				$this -> handle_categories();
			} else if($_GET['action'] == "category") {
				$this -> handle_category();
			} else {
				$this -> handle_summary();
			}
		}
		
		function handle_classifieds() {
			$arr = $this->m_adm->getAllItems();
			$mode = "classifieds";
			include("view/admin.php");
		}
		
		function handle_users() {
			$arr = $this->m_adm->getAllUsers();
			$mode = "users";
			include("view/admin.php");
		}
		
		function handle_categories() {
			$arr = $this->m_adm->getAllCategories();
			$mode = "categories";
			include("view/admin.php");
		}
		
		function handle_category() {
			if(isset($_GET['mode']) && $_GET['mode'] == "new") {
				$this->m_adm->addCategory($_REQUEST['title']);
				$this->handle_categories();
			} else if(isset($_GET['mode']) && $_GET['mode'] == "edit" && isset($_GET['id'])) {
				if(isset($_REQUEST['delete'])) {
					$this->m_adm->deleteCategory($_GET['id']);
					$this->handle_categories();
				} else {
					$this->m_adm->updateCategory($_GET['id'], $_REQUEST['title']);
					$this->handle_categories();
				}
				
			} else if(isset($_GET['mode']) && $_GET['mode'] == "add") {
				$cat_title = "";
				$form_mode = "new";
				include("view/add_modify_category.php");
			} else if (isset($_GET['id'])) {
				$cat_title = $this->m_adm->getCategory($_GET['id']);
				$form_mode = "edit";
				include("view/add_modify_category.php");
			} else {
				$this->handle_categories();
			}
		}

		function handle_summary() {
			$numUser = $this->m_adm->getNumUser();
			$numItems = $this->m_adm->getNumItems();
			$numCat = $this->m_adm->getNumCat();
			$mode = "summary";
			include("view/admin.php");
		}
	}
?>