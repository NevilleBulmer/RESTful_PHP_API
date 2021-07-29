<?php
class Configuration
{
    public static function getConfiguration($path = null)
    {
        // Checks if $path has been passed successfully. 
        if($path)
        {
            // Defines were config is coming or being loaded from.
            $config = $GLOBALS['config'];

            // Explodes the path by / and returns an array.
            $path = explode('/', $path);

            // print_r($path) Keep for testing.

            // loops throught the peices from the explode and sets it as $bit.
            foreach($path as $bit)
            {
                // checks if it has been or is set in the config.
                if(isset($config[$bit]))
                {
                    // Sets $config to $config plus $bit.
                    // This gives access to all of the information under mysql in initialise.php
                    // without this only mysql would be accesible.

                    // I.e. if echo Configuration::get('mysql/host'); it would return 127.0.0.1.
                    $config = $config[$bit];
                }
            }
            // Return $config ($config plus $bit).
            return $config;
        }
        // If $path was not or is not set then return false.
        return false;
    }
}
?>