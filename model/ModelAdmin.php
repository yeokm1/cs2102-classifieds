<?php

include_once("model/Item.php");
include_once("model/User.php");
include_once("model/Category.php");

class ModelAdmin {
	public function getAllItems() {
		include('db.php');
		if ($stmt = $conn->prepare("SELECT * FROM item")) {
			$stmt->execute();
			$result = $stmt->get_result();
			
			$arr = array();
			while($row = $result->fetch_assoc()) {
				$it = new Item($row['id'], $row['user'], $row['title'], $row['summary'],
					$row['description'], $row['cond'], $row['price'], $row['date_listed']);
				array_push($arr, $it);
			}
			
			$stmt->close();
		}
		
		return $arr;
	}
	
	public function getAllUsers() {
		include('db.php');
		if ($stmt = $conn->prepare("SELECT * FROM user")) {
			$stmt->execute();
			$result = $stmt->get_result();
			
			$arr = array();
			while($row = $result->fetch_assoc()) {
				$ur = new User($row['email'], $row['username'], $row['photo'], $row['gender'],
					$row['phone'], $row['join_date'], $row['role']);
				array_push($arr, $ur);
			}
			
			$stmt->close();
		}
		
		return $arr;
	}
	
	public function getAllCategories() {
		include('db.php');
		if ($stmt = $conn->prepare("SELECT * FROM category")) {
			$stmt->execute();
			$result = $stmt->get_result();
			
			$arr = array();
			while($row = $result->fetch_assoc()) {
				$cat = new Category($row['name']);
				array_push($arr, $cat);
			}
			
			$stmt->close();
		}
		
		return $arr;
	}

	public function updateCategory($oldName, $newName) {
		include('db.php');

		if($stmt = $conn->prepare("UPDATE category SET name = ? WHERE name = ?")) {
			$stmt->bind_param('ss', $newName, $oldName);
			$stmt->execute();
			echo $conn->error;
		}
	}

	public function addCategory($name) {
		include('db.php');
		if($stmt = $conn->prepare("INSERT INTO category (name) VALUES (?)")) {
			$stmt->bind_param('s', $_POST['title']);
			$stmt->execute();
			echo $conn->error;
		}
	}

	public function getCategory($name) {
		include('db.php');
		if($stmt = $conn->prepare("SELECT name FROM category c WHERE c.name = ?")) {
			$stmt->bind_param('s', $name);
			$stmt->execute();
			echo $conn->error;

			$result = $stmt->get_result();
			$stmt->close();
		}

		$row = $result->fetch_assoc();
		return $row['name'];
	}
	
	public function getNumUser() {
		include('db.php');
		if ($stmt = $conn->prepare("SELECT COUNT(*) FROM user")) {
			$stmt->execute();
			$result = $stmt->get_result();
			//$row = $result->fetch_assoc();
			$stmt->close();
		}

		$row=$result->fetch_assoc();
		
		return $row['COUNT(*)'];
	}
	
	public function getNumItems() {
		include('db.php');
		if ($stmt = $conn->prepare("SELECT COUNT(*) FROM item")) {
			$stmt->execute();
			$result = $stmt->get_result();
			//$row = $result->fetch_assoc();
			$stmt->close();
		}

		$row=$result->fetch_assoc();
		
		return $row['COUNT(*)'];
	}
	
	public function getNumCat() {
		include('db.php');
		if ($stmt = $conn->prepare("SELECT COUNT(*) FROM category")) {
			$stmt->execute();
			$result = $stmt->get_result();
			//$row = $result->fetch_assoc();
			$stmt->close();
		}

		$row=$result->fetch_assoc();
		
		return $row['COUNT(*)'];
	}

}
?>