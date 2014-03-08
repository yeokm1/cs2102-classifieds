<?php
	class Model {
		public function loginUser($username, $password) {
			return "success";
		}
		
		public function registerUser($username, $password, $confPassword) {
			return "success";
		}
		
		public function logoutUser() {
			session_unset();
			session_destroy();
		}
		
		public function addClassfied($username, $itemName, $itemType) {
		
			return "success";
		}
		
		public function editItem($itemID) {
			
			return "success";
		}
	}
?>