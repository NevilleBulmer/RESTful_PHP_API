<?php 
// Holds the functionality for session handling 
class Session 
{
    // Checks if a session exists with $name I.e. session name.
  	public static function exists($name)
  	{
        // Returns wether the session is set if it is then return true
        // otherwise return false.
        return (isset($_SESSION[$name])) ? true : false;
  	}

    // Returns the value of a given session I.e. a users session with a 
    // session name and a session value.
   	public static function put($name, $value)
   	{
        // Return the value of a given session.
        return $_SESSION[$name] = $value;
   	}

    // Returns the session.
   	public static function get($name)
   	{
        // Return the name of a given session.
        return $_SESSION[$name];
   	}

    // Deletes the session.
   	public static function delete($name)
   	{
        // If a session exists.
 	    if (self::exists($name)) {

            // Then unset the session I.e. delete the session.
   	        unset($_SESSION[$name]);
 	    }
   	}


    // Session flash messages, I.e. Session::sessionFlashMessage();
    // This is used to display a flash message to the user and as soon as 
    // the page refreshes the message disappears.
    // It takes a name I.e. admin and an empty string I.e. 'you must be an admin' 
    // (an example of this can be found on createHoliday.php).
    public static function sessionFlashMessage($name, $string = '')
    {
        // If session exists using a name I.e. session name.
        if (self::exists($name)) {

            // Returns the session data I.e. session name
            $session = self::get($name);
            
            // Deletes the session flash data I.e. session name,
            // Once a page refresh has occured the session flash 
            // data is deleted.
            self::delete($name);
            
            // Return the current session.
            return $session;

        // If the above if statement doesnt work.
        } else {

        // Returns session name and a session value.
        self::put($name, $string);
        }
    }
}
?>