<?php
class BusinessCard {
	public $id;
	public $firstName;
	public $lastName;
	public $userId;
	public $title;
	public $email;
	public $phone;
	public $address;
	public $public;
	private $lastLat;
	private $lastLng;
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}
	
	public function getFirstName() {
		return $this->firstName;
	}
	
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}
	
	public function getLastName() {
		return $this->lastName;
	}
	
	public function setUserId($userId) {
		$this->userId = $userId;
	}
	
	public function getUserId() {
		return $this->userId;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setEmail($email) {
		$this->email = $email;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function setPhone($phone) {
		$this->phone = $phone;
	}
	
	public function getPhone() {
		return $this->phone;
	}
	
	public function setAddress($address) {
		$this->address = $address;
	}
	
	public function getAddress() {
		return $this->address;
	}
	
	public function setPublic($public) {
		$this->public = $public;
	}
	
	public function getPublic() {
		return $this->public;
	}
	
	public function setLastLat($lastLat) {
		$this->lastLat = $lastLat;
	}
	
	public function getLastLat() {
		return $this->lastLat;
	}
	
	public function setLastLng($lastLng) {
		$this->lastLng = $lastLng;
	}
	
	public function getLastLng() {
		return $this->lastLng;
	}
	
	public function save() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "INSERT INTO business_cards (user_id, title,  email, phone, address, public) 
			VALUES ('" . $this->getUserId() . "', '" . $this->getTitle() . "', '" . $this->getEmail() . "', '" . $this->getPhone() . "','" . $this->getAddress() . "', " . $this->getPublic() . ")";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	public function update() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "UPDATE business_cards
			      SET title = '" . $this->getTitle() . "', email = '" . $this->getEmail() . "', phone = '" . $this->getPhone() . "', address = '" . $this->getAddress() . "', public = " . $this->getPublic() . "
				  WHERE id = " . $this->getId() . " AND user_id = " . $this->getUserId() . ";";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	public function delete() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "DELETE FROM business_cards 
				  WHERE id = " . $this->getId() . " AND user_id = " . $this->getUserId() . ";";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
}
?>