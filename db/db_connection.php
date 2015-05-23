<?php
class Database {
	public static $link;
	
	// get the database connection
	public static function getDBConnection() {
		if (Database::$link == null) {
			Database::$link = mysqli_connect("mysql8.000webhost.com", "a4540945_user", "Loredana1", "a4540945_db");
			if (!Database::$link) { 
				die('Could not connect to MySQL: ' . mysql_error()); 
			}

			return Database::$link;
		} else {
			return Database::$link;
		}
	}	
}
?>