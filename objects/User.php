<?php
class User {
	public $id;
	public $firstName;
	public $lastName;
	public $username;
	public $password;
	public $lastLat;
	public $lastLng;
	public $lastGPSUpdate;
	public $gcmRegId;
	public $distance;
	
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
	
	public function setLastGPSUpdate($lastGPSUpdate) {
		$this->lastGPSUpdate = $lastGPSUpdate;
	}
	
	public function getLastGPSUpdate() {
		return $this->lastGPSUpdate;
	}
	
	public function setGCMRegId($gcmRegId) {
		$this->gcmRegId = $gcmRegId;
	}
	
	public function getGCMRegId() {
		return $this->gcmRegId;
	}
	
	public function setDistance($distance) {
		$this->distance = $distance;
	}
	
	public function getDistance() {
		return $this->distance;
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
	
	public static function getById($userId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		$query = "SELECT * 
			      FROM users 
				  WHERE id = " . $userId . ";";
		$result = mysqli_query($link, $query);

		$user = new User();
		while($row = mysqli_fetch_array($result)) {
			$user->setId($userId);
			$user->setFirstName($row["first_name"]);
			$user->setLastName($row["last_name"]);
			$user->setUsername($row["username"]);
			$user->setLastLat($row["last_lat"]);
			$user->setLastLng($row["last_lng"]);
			$user->setLastGPSUpdate($row["last_gps_update"]);
			$user->setGCMRegId($row["gcm_reg_id"]);
		}
		
		return $user;
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
			$card->setPublic($row["public"]);
			$card->setLayout($row["layout"]);
			
			$myCards[] = $card;
		}

		return $myCards;
	}
	
	public static function getSavedCards($userId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		include_once (Utils::$relativePath . "objects/BusinessCard.php");
		$link = Database::getDBConnection();
		
		$query = "SELECT bc.user_id, uc.card_id, bc.title, bc.email, bc.phone, bc.address, bc.public, bc.layout, u.first_name, u.last_name, u.username
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
			$card->setPublic($row["public"]);
			$card->setFirstName($row["first_name"]);
			$card->setLastName($row["last_name"]);
			$card->setLayout($row["layout"]);
			
			$savedCards[] = $card;
		}

		return $savedCards;
	}
	
	public function updateGPSLocation() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		
		$query = "UPDATE users 
				  SET last_lat = '" . $this->getLastLat() . "', last_lng = '" . $this->getLastLng() . "', last_gps_update = '" . $this->getLastGPSUpdate() . "' 
				  WHERE id = " . $this->getId() . ";";
				  
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	public function updateLogout() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		
		$query = "UPDATE users 
				  SET last_lat = NULL, last_lng = NULL, last_gps_update = NULL, gcm_reg_id = NULL 
				  WHERE id = " . $this->getId() . ";";
				  
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	public function updateGCMRegId() {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		
		$query = "UPDATE users 
				  SET gcm_reg_id = '" . $this->getGCMRegId() . "' 
				  WHERE id = " . $this->getId() . ";";
				  
		if (!mysqli_query($link, $query)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	public static function getShareUsers($userId, $distance, $lat, $lng) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		
		$querySelectUsersEvents = "SELECT event_id 
				  FROM events_users 
				  WHERE user_id = " . $userId . "";
				  
		$queryUsersFromEvents = "SELECT DISTINCT user_id 
				  FROM events_users 
				  WHERE event_id in(" . $querySelectUsersEvents . ") AND user_id <> " . $userId . ";";
		$result = mysqli_query($link, $queryUsersFromEvents);  
		
		$userIdsFromEvents = array(); // need to be added to the final list
		while($row = mysqli_fetch_array($result)) {
			$userIdsFromEvents[] = $row["user_id"];
		}
		
		if (count($userIdsFromEvents) > 0) {	
			$userIdsFromEventsString = "";
			for ($i = 0; $i < count($userIdsFromEvents); $i++) {
				if ($i == (count($userIdsFromEvents) - 1)) {
					// last element from list
					$userIdsFromEventsString .= $userIdsFromEvents[$i];
				} else {
					$userIdsFromEventsString .= $userIdsFromEvents[$i] . ", ";
				}
			}
		
			$queryEventsUsers = "SELECT * 
				  FROM users 
				  WHERE id IN (" . $userIdsFromEventsString . ") AND last_lat IS NOT NULL AND last_lng IS NOT NULL AND gcm_reg_id IS NOT NULL;";	  
			$result3 = mysqli_query($link, $queryEventsUsers);
		
			$eventsUsers = array();
			while($row = mysqli_fetch_array($result3)) {
				$user = new User();
				$user->setId($row["id"]);
				$user->setFirstName($row["first_name"]);
				$user->setLastName($row["last_name"]);
				$user->setUsername($row["username"]);
				$user->setLastLat($row["last_lat"]);
				$user->setLastLng($row["last_lng"]);
				$user->setLastGPSUpdate($row["last_gps_update"]);
				$user->setGCMRegId($row["gcm_reg_id"]);
				$eventsUsers[] = $user;
			}
		}
		
		$userIdsFromEventsString = "";
		for ($i = 0; $i < count($userIdsFromEvents); $i++) {
			$userIdsFromEventsString .= $userIdsFromEvents[$i] . ", ";
		}
		
		$userIdsFromEventsString .= $userId;
		
		$queryNearbyUsers = "SELECT * 
				  FROM users 
				  WHERE id NOT IN (" . $userIdsFromEventsString . ") AND last_lat IS NOT NULL AND last_lng IS NOT NULL AND gcm_reg_id IS NOT NULL;";
		$result2 = mysqli_query($link, $queryNearbyUsers);
		
		$allUsers = array();
		while($row = mysqli_fetch_array($result2)) {
			$user = new User();
			$user->setId($row["id"]);
			$user->setFirstName($row["first_name"]);
			$user->setLastName($row["last_name"]);
			$user->setUsername($row["username"]);
			$user->setLastLat($row["last_lat"]);
			$user->setLastLng($row["last_lng"]);
			$user->setLastGPSUpdate($row["last_gps_update"]);
			$user->setGCMRegId($row["gcm_reg_id"]);
			$allUsers[] = $user;
		}
		
		$nearbyUsers = array();
		for ($i = 0; $i < count($allUsers); $i++) {
			$user = $allUsers[$i];
			$distanceToUser = User::getDistanceToUser($user, $lat, $lng);
			if ($distanceToUser < $distance) {
				$user->setDistance($distanceToUser);
				$nearbyUsers[] = $user;
			}
		}

		$users = array_merge($eventsUsers, $nearbyUsers);
		
		return $users;
	}
	
	public static function getNearbyCards($userId, $distance, $lat, $lng) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		include_once (Utils::$relativePath . "objects/BusinessCard.php");
		$link = Database::getDBConnection();
		
		$query = "SELECT bc.id, bc.user_id, bc.title, bc.email, bc.phone, bc.address, bc.public, bc.layout, u.first_name, u.last_name, 
						u.last_lat, u.last_lng 
			      FROM business_cards bc
				  LEFT JOIN users u ON bc.user_id = u.id 
				  WHERE u.gcm_reg_id IS NOT NULL AND bc.public = 1 AND bc.user_id <> " . $userId . " AND u.last_lat IS NOT NULL AND u.last_lng IS NOT NULL;";
		$result = mysqli_query($link, $query);
		
		$matchingCards = array();
		while($row = mysqli_fetch_array($result)) {
			$card = new BusinessCard();
			$card->setId($row["id"]);
			$card->setUserId($row["user_id"]);
			$card->setTitle($row["title"]);
			$card->setEmail($row["email"]);
			$card->setPhone($row["phone"]);
			$card->setAddress($row["address"]);
			$card->setPublic($row["public"]);
			$card->setFirstName($row["first_name"]);
			$card->setLastName($row["last_name"]);
			$card->setLastLat($row["last_lat"]);
			$card->setLastLng($row["last_lng"]);
			$card->setLayout($row["layout"]);
			
			$matchingCards[] = $card;
		}
		
		$query2 = "SELECT bc.id
			      FROM users_cards uc
				  LEFT JOIN business_cards bc ON bc.id = uc.card_id 
				  WHERE uc.user_id = " . $userId . ";";
		$result2 = mysqli_query($link, $query2);
		
		$alreadyAddedCardIds = array();
		while($row = mysqli_fetch_array($result2)) {
			$alreadyAddedCardIds[] = $row["id"];
		}

		$nearbyCards = array();
		for ($i = 0; $i < count($matchingCards); $i++) {
			$matchingCard = $matchingCards[$i];
			$distanceToCard = User::getDistanceToCard($matchingCard, $lat, $lng);
			if ($distanceToCard < $distance && !in_array($matchingCard->getId(), $alreadyAddedCardIds)) {
				$matchingCard->setDistance($distanceToCard);
				$nearbyCards[] = $matchingCard;
			}
		}
		
		return $nearbyCards;
	}
	
	private static function getDistanceToCard($card, $lat, $lng) {
		$cardLat = $card->getLastLat();
		$cardLng = $card->getLastLng();
		
		$pi80 = M_PI / 180;
		$lat *= $pi80;
		$lng *= $pi80;
		$cardLat *= $pi80;
		$cardLng *= $pi80;
 
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $cardLat - $lat;
		$dlng = $cardLng - $lng;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat) * cos($cardLat) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = ($r * $c) * 1000;
		
		return $km;
	}
	
	private static function getDistanceToUser($user, $lat, $lng) {
		$userLat = $user->getLastLat();
		$userLng = $user->getLastLng();
		
		$pi80 = M_PI / 180;
		$lat *= $pi80;
		$lng *= $pi80;
		$userLat *= $pi80;
		$userLng *= $pi80;
 
		$r = 6372.797; // mean radius of Earth in km
		$dlat = $userLat - $lat;
		$dlng = $userLng - $lng;
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat) * cos($userLat) * sin($dlng / 2) * sin($dlng / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km = ($r * $c) * 1000;
		
		return $km;
	}
	
	public static function addPublicCard($userId, $cardId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		$link = Database::getDBConnection();
		
		$query = "SELECT * 
			      FROM users_cards 
				  WHERE user_id = " . $userId . " AND card_id = " . $cardId . ";";
		$result = mysqli_query($link, $query);
		
		while($row = mysqli_fetch_array($result)) {
			return "User already has access to this card";
		}
		
		$query2 = "INSERT INTO users_cards (user_id, card_id) 
			VALUES (" . $userId . ", " . $cardId .  ")";
		
		if (!mysqli_query($link, $query2)) {
  			die('Error: ' . mysqli_error($link));
		}
	}
	
	public static function joinEvent($userId, $passcode) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		include_once (Utils::$relativePath . "objects/Event.php");
		$link = Database::getDBConnection();
		
		$event = Event::getByPasscode($passcode);
		if ($event->getId() == -1) {
			return "Event does not exist";
		}
		
		$query = "SELECT * 
			      FROM events_users 
				  WHERE event_id = " . $event->getId() . " AND user_id = " . $userId . ";";
		$result = mysqli_query($link, $query);
		
		while($row = mysqli_fetch_array($result)) {
			return "User already added to event";
		}
		
		$query2 = "INSERT INTO events_users (event_id, user_id) 
			VALUES (" . $event->getId() . ", " . $userId .  ")";
		
		if (!mysqli_query($link, $query2)) {
  			die('Error: ' . mysqli_error($link));
		}
		
		return $event->getName();
	}
	
	public static function getUserEvents($userId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		include_once (Utils::$relativePath . "objects/Event.php");
		$link = Database::getDBConnection();
		
		$query = "SELECT c.id, c.name, c.location, c.date, c.passcode 
			      FROM events_users cu 
				  LEFT JOIN events c ON cu.event_id = c.id 
				  LEFT JOIN users u ON u.id = cu.user_id
				  WHERE user_id = " . $userId . ";";
		$result = mysqli_query($link, $query);
		
		$myEvents = array();
		while($row = mysqli_fetch_array($result)) {
			$event = new Event();
			$event->setId($row["id"]);
			$event->setName($row["name"]);
			$event->setLocation($row["location"]);
			$event->setDate($row["date"]);
			$event->setPasscode($row["passcode"]);
			
			$myEvents[] = $event;
		}

		return $myEvents;
	}
	
	public static function getEventCards($userId, $eventId) {
		include_once (Utils::$relativePath . "db/db_connection.php");
		include_once (Utils::$relativePath . "objects/BusinessCard.php");
		$link = Database::getDBConnection();
		
		$query = "SELECT bc.id, bc.user_id, bc.title, bc.email, bc.phone, bc.address, bc.public, bc.layout, u.first_name, u.last_name 
			      FROM business_cards bc 
				  LEFT JOIN users u ON bc.user_id = u.id 
				  LEFT JOIN events_users cu ON cu.user_id = u.id 
				  WHERE cu.event_id = " . $eventId . " AND cu.user_id <> " . $userId . ";";

		$result = mysqli_query($link, $query);
		
		$matchingCards = array();
		while($row = mysqli_fetch_array($result)) {
			$card = new BusinessCard();
			$card->setId($row["id"]);
			$card->setUserId($row["user_id"]);
			$card->setTitle($row["title"]);
			$card->setEmail($row["email"]);
			$card->setPhone($row["phone"]);
			$card->setAddress($row["address"]);
			$card->setPublic($row["public"]);
			$card->setFirstName($row["first_name"]);
			$card->setLastName($row["last_name"]);
			$card->setLayout($row["layout"]);
			
			$matchingCards[] = $card;
		}
		
		$query2 = "SELECT bc.id
			      FROM users_cards uc
				  LEFT JOIN business_cards bc ON bc.id = uc.card_id 
				  WHERE uc.user_id = " . $userId . ";";
		$result2 = mysqli_query($link, $query2);
		
		$alreadyAddedCardIds = array();
		while($row = mysqli_fetch_array($result2)) {
			$alreadyAddedCardIds[] = $row["id"];
		}
		
		$eventCards = array();
		for ($i = 0; $i < count($matchingCards); $i++) {
			$matchingCard = $matchingCards[$i];
			if (!in_array($matchingCard->getId(), $alreadyAddedCardIds)) {
				$eventCards[] = $matchingCard;
			}
		}
		
		return $eventCards;
	}
}
?>