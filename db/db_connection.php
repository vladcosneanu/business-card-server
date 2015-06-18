<?php
class Database {
	public static $link;
	
	// get the database connection
	public static function getDBConnection() {
		if (Database::$link == null) {
			Database::$link = mysqli_connect("mysql3.000webhost.com", "a6302809_user", "123456A", "a6302809_db");
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