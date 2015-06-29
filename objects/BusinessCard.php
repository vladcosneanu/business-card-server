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
	public $distance;
	public $layout;
	
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
	
	public function setDistance($distance) {
		$this->distance = $distance;
	}
	
	public function getDistance() {
		return $this->distance;
	}
	
	public function setLayout($layout) {
		$this->layout = $layout;
	}
	
	public function getLayout() {
		return $this->layout;
	}
	
	// get a card from the database, by its id
	public static function getById($cardId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "SELECT * 
			      FROM business_cards 
				  WHERE id = " . $cardId . ";";
		$result = mysqli_query($link, $query);

		$card = new BusinessCard();
		while($row = mysqli_fetch_array($result)) {
			$card->setId($row["id"]);
			$card->setUserId($row["user_id"]);
			$card->setTitle($row["title"]);
			$card->setEmail($row["email"]);
			$card->setPhone($row["phone"]);
			$card->setAddress($row["address"]);
			$card->setPublic($row["public"]);
			$card->setLayout($row["layout"]);
		}
		
		return $card;
	}
	
	public function save() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "INSERT INTO business_cards (user_id, title,  email, phone, address, layout, public) 
			VALUES ('" . $this->getUserId() . "', '" . $this->getTitle() . "', '" . $this->getEmail() . "', '" . $this->getPhone() . "','" . $this->getAddress() . "', " . $this->getLayout() . ", " . $this->getPublic() . ")";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	public function update() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "UPDATE business_cards
			      SET title = '" . $this->getTitle() . "', email = '" . $this->getEmail() . "', phone = '" . $this->getPhone() . "', address = '" . $this->getAddress() . "', layout = " . $this->getLayout() . ", public = " . $this->getPublic() . "
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
		
		$query2 = "DELETE FROM users_cards 
				  WHERE card_id = " . $this->getId() . ";";
		
		if (!mysqli_query($link, $query2)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	// delete a card from a user's Saved Cards list
	public function deleteSaved() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "DELETE FROM users_cards 
				  WHERE card_id = " . $this->getId() . " AND user_id = " . $this->getUserId() . ";";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
}
?>