<?php
// Input class which holds two functions, inputExists and get.
Class CheckInput {

	// inputExists is used to check if input inputExists I.e. 
	// CheckInput::inputExists in multiple files throughout this 
	// website.
  	public static function inputExists($type = 'post')
  	{
	    switch ($type) 
	    {
	    	// If post, check if is empty.
	      	case 'post':
	          	return (!empty($_POST)) ? true : false;
	        break;

	        // If get, check if is empty.
	      	case 'get':
	        	return (!empty($_GET)) ? true : false;
	      	break;

	      	// Default return false.
	      	default:
	          	return false;
	        break;
	    }
  	}

 	// CheckInput::get is used to get the input whatever it may be.

  	// CheckInput::post is used to post the information.

	// Allways assume there is data but returning an empty
	// string prevents problems if there is no data to be found.
  	public static function get($item)
  	{
  		// If post is set then post the item.
	    if (isset($_POST[$item])) 
	    {
	      	return $_POST[$item];

	    // If get is set then get the item.
	    } else if (isset($_GET[$item])) 
	    {
	      	return $_GET[$item];
	    }
	    	// Default return an empty string.
	    	return '';
  	}
}

?>