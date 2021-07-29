<?php

// Entry point or start php (Set session).
session_start();

// Config to specify the database details in an array.
$GLOBALS['config'] = array
(
	// Array of config settings I.e. host IP, username, password, db name.
	'mysql' => array(
		// Host IP.
		'host' => 'localhost',
		// Username for the database.
		'username' => 'root',
		// Password for the database.
		'password' => '',
		// Name of the database.
		'db' => 'hyldu_admin'

	),

	// The session name.
	'session' => array
    (
    	// Session name.
        'session_name' => 'user',
        'token_name' => 'token'
	)
);

// Dynamically load in required classes.
// This replaces the need to load each class individually
// an example of this would be require_once 'PHP/classes/Hash.php';.

// This also eliminates the need to rename any of the classes in this
// file if the name of the class file is changed.
spl_autoload_register(function($class)
{
	require_once($_SERVER['DOCUMENT_ROOT'] . '/HylduThree/lib/PHP/classes/' . $class . '.php');
});

// Require in sanitize.
require_once($_SERVER['DOCUMENT_ROOT'] . '/HylduThree/lib/PHP/functions/sanitizeString.php');
?>