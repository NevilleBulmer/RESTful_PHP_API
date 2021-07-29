<?php

// Function to escape strings it takes a string
// and using ENT_QUOTES (Will convert both double and single quotes)
// and UTF-8 is the specified formatting.

function escape($string)
{
	// Htmlentities ensures all substrings have associated named 
	// entities translated.
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}
?>