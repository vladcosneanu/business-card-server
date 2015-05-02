<?php
class Conference {
	public $id;
	public $name;
	public $location;
	public $date;
	public $passcode;
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setLocation($location) {
		$this->location = $location;
	}
	
	public function getLocation() {
		return $this->location;
	}
	
	public function setDate($date) {
		$this->date = $date;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function setPasscode($passcode) {
		$this->passcode = $passcode;
	}
	
	public function getPasscode() {
		return $this->passcode;
	}
	
	public static function getByPasscode($passcode) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "SELECT * 
			      FROM conferences 
				  WHERE passcode = '" . $passcode . "';";
		$result = mysqli_query($link, $query);

		$conference = new Conference();
		$conference->setId(-1);
		while($row = mysqli_fetch_array($result)) {
			$conference->setId($row["id"]);
			$conference->setName($row["name"]);
			$conference->setLocation($row["location"]);
			$conference->setDate($row["date"]);
			$conference->setPasscode($row["passcode"]);
		}
		
		return $conference;
	}
	
	public static function deleteJoined($userId, $conferenceId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "DELETE FROM conferences_users 
				  WHERE user_id = " . $userId . " AND conference_id = " . $conferenceId . ";";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
}
?>