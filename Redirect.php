<?php
// A redirect class to eliminate having to use header('Example.php').
class Redirect
{	

	// The class takes a location specified in an external class as 
	// Redirect::redirectTo(Example) 
	// this adds more functionality as using this class the user can 
	// be directed an error template I.e. 404 - Or any other
	// error template we would require (Could add functionality to 
	// display custom messages dependant on the error).
	public static function redirectTo($location = null)
	{
		if($location)
		{	
			if(is_numeric($location))
			{
				switch($location)
				{
					// In case of a 404 error.
					case 404:
					header('HTTP/1.0 404 Not Found');
					include 'PHP/includes/errors/404.php';
					exit();

					break;

					// In case of a 403 error.
					case 403:
					header('HTTP/1.0 403 Forbidden');
					include 'PHP/includes/errors/403.php';
					exit();

					break;
				}
			}
			// Used in the code to redirect to a specified location
			// I.e. Redirect::redirectTo();
			header('Location: ' . $location);
			exit();
		}
	}

}

?>