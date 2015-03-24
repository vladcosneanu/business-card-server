<?php
class User {
	private $id;
	private $firstName;
	private $lastName;
	private $username;
	private $password;
	
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
	
	public function setUsername($username) {
		$this->username = $username;
	}
	
	public function getUsername() {
		return $this->username;
	}
	
	public function setPassword($password) {
		$this->password = $password;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function save() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "INSERT INTO users (first_name, last_name, username, password) 
			VALUES ('" . $this->getFirstName() . "', '" . $this->getLastName() . "','" . $this->getUsername() . "', SHA1('" . $this->getPassword(). "'))";
		
		if (!mysqli_query($link, $query)) {
  			die('Error aici: ' . mysqli_error($link));
		}
	}

	public static function isUsernameAvailable($username){
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "SELECT * FROM users WHERE username = '" . $username . "';";
		$result = mysqli_query($link, $query);
		
		while($row = mysqli_fetch_array($result)) {
			return false;
		}
		return true;
	}
	
	public static function getMyCards($userId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		include_once (Utils::$relativePath . "objects/BusinessCard.php");
		$link = Database::getDBConnection();
		
		$query = "SELECT * FROM business_cards WHERE user_id = " . $userId . ";";
		$result = mysqli_query($link, $query);
		
		$myCards = array();
		while($row = mysqli_fetch_array($result)) {
			$card = new BusinessCard();
			$card->setId($row["id"]);
			$card->setUserId($row["user_id"]);
			$card->setTitle($row["title"]);
			$card->setEmail($row["email"]);
			$card->setPhone($row["phone"]);
			$card->setAddress($row["address"]);
			
			$myCards[] = $card;
		}

		return $myCards;
	}
	
	public static function getSavedCards($userId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		include_once (Utils::$relativePath . "objects/BusinessCard.php");
		$link = Database::getDBConnection();
		
		$query = "SELECT bc.user_id, uc.card_id, bc.title, bc.email, bc.phone, bc.address, u.first_name, u.last_name, u.username
				  FROM users_cards uc
			      LEFT JOIN business_cards bc ON uc.card_id = bc.id 
				  LEFT JOIN users u ON bc.user_id = u.id 
				  WHERE uc.user_id = " . $userId . ";";
		
		$result = mysqli_query($link, $query);
		
		$savedCards = array();
		while($row = mysqli_fetch_array($result)) {
			$card = new BusinessCard();
			$card->setId($row["card_id"]);
			$card->setUserId($row["user_id"]);
			$card->setTitle($row["title"]);
			$card->setEmail($row["email"]);
			$card->setPhone($row["phone"]);
			$card->setAddress($row["address"]);
			$card->setFirstName($row["first_name"]);
			$card->setLastName($row["last_name"]);
			
			$savedCards[] = $card;
		}

		return $savedCards;
	}
}
?>