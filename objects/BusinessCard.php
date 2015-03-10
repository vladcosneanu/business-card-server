<?php
class BusinessCard {
	private $id;
	private $userId;
	private $email;
	private $phone;
	private $address;
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setUserId($userId) {
		$this->userId = $userId;
	}
	
	public function getUserId() {
		return $this->userId;
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
	
	public function save() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "INSERT INTO business_cards (user_id, email, phone, address) 
			VALUES ('" . $this->getUserId() . "', '" . $this->getEmail() . "', '" . $this->getPhone() . "','" . $this->getAddress() . "')";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
}
?>