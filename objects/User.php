<?php
class User {
	private $id;
	private $title;
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
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
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
		$query = "INSERT INTO users (title, first_name, last_name, username, password) 
			VALUES ('" . $this->getTitle() . "', '" . $this->getFirstName() . "', '" . $this->getLastName() . "','" . $this->getUsername() . "', SHA1('" . $this->getPassword(). "'))";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
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
}
?>