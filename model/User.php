<?php
	class User {
		public $email;
		public $username;
		public $photo;
		public $gender;
		public $phone;
		public $join_date;
		public $role;
	

		public function __construct($email, $username, $photo, $gender, $phone, $join_date, $role) {  
			$this->email = $email;
			$this->username = $username;
			$this->photo = $photo;
			$this->gender = $gender;
			$this->phone = $phone;
			$this->join_date = $join_date;
			$this->role = $role;
		} 
	}
?>