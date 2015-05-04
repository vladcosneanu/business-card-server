<?php
class Event {
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
			      FROM events 
				  WHERE passcode = '" . $passcode . "';";
		$result = mysqli_query($link, $query);

		$event = new Event();
		$event->setId(-1);
		while($row = mysqli_fetch_array($result)) {
			$event->setId($row["id"]);
			$event->setName($row["name"]);
			$event->setLocation($row["location"]);
			$event->setDate($row["date"]);
			$event->setPasscode($row["passcode"]);
		}
		
		return $event;
	}
	
	public static function deleteJoined($userId, $eventId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "DELETE FROM events_users 
				  WHERE user_id = " . $userId . " AND event_id = " . $eventId . ";";
		
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
}
?>