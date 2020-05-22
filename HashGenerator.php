<?php
class HashGenerator
{
	// A function which makes a hash.
    // It takes a string and a salt which is then used to create a hash using sha256.
	public static function makeHash($string, $salt = '')
    {
        return hash('sha256', $string . $salt);
    }

	// A function which generates a salt.
    public static function generateSalt($length)
	{
        return openssl_random_pseudo_bytes($length);
          
          
        // $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
        // $randString = "";
        // $randStringLen = 64;
    
        // while(strlen($randString) < $randStringLen) {
        //     $randChar = substr(str_shuffle($charset), mt_rand(0, strlen($charset)), 1);
        //     $randString .= $randChar;
        // }

        // return $randString;
}

    // A function which makes a unique hash.
	public static function generateUnique()
	{
  	 return self::make(uniqid());
	}
}

?>