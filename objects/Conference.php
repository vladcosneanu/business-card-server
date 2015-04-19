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
}
?>