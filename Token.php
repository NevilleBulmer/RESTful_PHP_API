<?php
    // Class which is responsible for generating and chacking a JSON token
    class Token
    {
        // Function responsible for generating a JSON token.
        public static function generate()
        {            
            // Return the JSON token.
            return Session::put(Configuration::getConfiguration('session/token_name'), md5(uniqid()));
        }

        // Function responsible for checking a JSON token.
        public static function check($token)
        {
            // Retrieves the token name which has been generated.
            $tokenName = Configuration::getConfiguration('session/token_name');

            // Checks if a sesson/token exists.
            if(Session::exists($tokenName) && $token === Session::get($tokenName))
            {
                // If a token exists, then remove it to generate a new one.
                Session::delete($tokenName);
                // Return true if the above is applicable.
                return true;
            }

            // Else return false.
            return false;
        }
    }
?>