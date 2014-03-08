<?php
	class Item {
	public $id;
	public $user;
	public $title;
	public $summary;
	public $description;
	public $cond;
	public $price;
	public $date_listed;
	

		public function __construct($id, $user, $title, $summary, $description, $cond, $price, $date_listed) {  
			$this->id = $id;
			$this->user = $user;
			$this->title = $title;
			$this->summary = $summary;
			$this->description = $description;
			$this->cond = $cond;
			$this->price = $price;
			$this->date_listed = $date_listed;
		} 
	}
?>