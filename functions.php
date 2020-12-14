<?php
function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    require_once 'config/config.php'
    
    try {
    	return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	die ('Failed to connect to database!');
    }
}


