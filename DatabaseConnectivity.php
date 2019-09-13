<?php
// A singletone DatabaseConnectivity class which holds all 
// of the database connectivity code for the entire project.

// It takes functionality which is already native and built into PDO
// and extracts it to make it more user friendly and managhable.
class DatabaseConnectivity
{
    // Private instance Used for initialising the database object.
    private static $_instance = null;

    // Private variables.
            // Stores the pdo/database object.
    private $_pdo,
            // Stores the last query which was executed.
            $_query,
            // represents and stores an error if one ocured I.e. wether a query failed or not.
            $_error = false,
            // Stores a result set in an array I.e a query which returns every item from a 
            // database with the ID 10.
            $_results = array(),
            // The count of results.
            $_count = 0;

    // Constructs an instance of the database connectivity class.
    private function __construct()
    {
        // Information passed in from Configuration.php (Connection details).
        // I.e. host, dbname, username, password.
        // These are specified in Configuration.php and passed in. 
        try {
            // The initial string I.e. mysql defines the database handler you are using/connecting to, 
            // host specifies the host I.e. the IP address,
            // dbname specifies the database name,
            // username specifies the username for connecting to the database,
            // password specifies the password for connecting to the database.
            $this->_pdo = new PDO('mysql:host=' .
                Configuration::getConfiguration('mysql/host') . ';dbname=' .
                Configuration::getConfiguration('mysql/db'),
                Configuration::getConfiguration('mysql/username'),
                Configuration::getConfiguration('mysql/password')
            );
        // Catch exceptions. 
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Gets and instance of the DatabaseConnectivity object.
    public static function getInstance()
    {
        // If $_instance is not set then set it to a new instance ofDatabaseConnectivity.
        if (!isset(self::$_instance)) {
            self::$_instance = new DatabaseConnectivity();
        }

        // If it is set then return it.
        return self::$_instance;
    }

    // Query the database 
    public function query($sql, $params = array())
    {
        // If _error is false which it is set to false then the code runs
        // this eliminates errors from previously ran queries as multiple 
        // queries can be ran one after another.
        $this->_error = false;

        // Assigns _query equal to a prepared statement and checks 
        // (makes sure) that _query is equal to a prepared statement.
        if($this->_query = $this->_pdo->prepare($sql)) {

            // Instantiated $x to 1.
            $x=1;

            // Count through the params array as params to check that they exist.
            if(count($params))
            {
                // Foreach to loop through parameters.
                foreach($params as $param)
                {
                    // Binds the position of a selected parameter to param
                    // I.e. $x = 1 so param would be the first ? in a query.
                    $this->_query->bindValue($x, $param);

                    // Each loop throught the foreach will increment $x by ++ I.e. 1.
                    $x++;
                }
            }

            // Executes the query while checking that it was executed successfully
            if($this->_query->execute())
            {
                // Sets/Updates _results equal to the query plus fetchAll(PDO::FETCH_OBJ);.
                // I have don it this way as I have built this in an OOP style
                // so I didnt want to return an array it also wouldnt make sense to.
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);

                // Sets/Updates _count equal to the query plus rowCount();.
                $this->_count = $this->_query->rowCount();
            }else{
                // If the above if statement fails then set _error to true returning an
                // error.
                $this->_error = true;
            }
        }
        // Returns the current object being worked with or handled at that time.
        return $this;
    }

    // Perform and action I.e. SELECT * FROM users WHERE SOMETHING = SOMETHING.
	public function action($action, $table, $where = array())
    {
    	// An example of the code below in simple terms would be.
        // (count($where) === 3) equates to the field, operater and value I.e. 'username' '=' 'neville'.
    	if(count($where) === 3)
    	{
            // Allowed operators array.
    		$operators = array('=','>','<','>=', '<=');

            // Field I.e. ID.
    		$field = $where[0];

            // Operator I.e. =, >, <.
    		$operator = $where[1];

            // Value I.e. returned information.
    		$value = $where[2];

    		// Checks if the operator is inside the operators array.
    		if(in_array($operator, $operators))
    		{
                // SQL Statement.
                // I.e. sql is equal to the statement.
                // Action I.e. SELECT FROM a table I.e. users WHERE field I.e. ID operator I.e. = ?.
    			$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                // If there was not an error return $this.
    			if (!$this->query($sql, array($value))->error()) {

                    // Returns the current object being worked with or handled at that time. 
                    return $this;
    			}
    		}
    	}
        // If all else fails return false.
        return false;
    }

    // Inserts a new record into the database with a table and an array of fields.
    public function insert($table, $fields = array())
    {
        // count($fields) finds data in the fields array.
        if(count($fields))  
        {
            // Instantiated $keys to an array of keys which are the fields in which we want to inssert into.
            // I.e. username, name, password.
            $keys = array_keys($fields);
            
            // Instantiated $value to an empty string, essentially keeps track of the ?. 
            $values = '';
            
            // Instantiated $x to 1.
            $x = 1;

            // Loop through the fields as field.
            foreach($fields as $field) 
            {
                // Each iteeration of the foreach loop adds a ? to $values.
                $values .= '?';

                // Checks if $x is less than the count of $fields and if it is.
                if($x < count($fields)) 
                {
                    // Adds a , (coma) in between the question marks.
                    $values .= ', ';
                }
                // Each loop throught the foreach will increment $x by ++ I.e. 1.
                $x++;
            }

            // SQL Statement.
            // I.e. sql is equal to the statement.
            // The concatination of the strings and variable below is explained as follows
            // Implode will implode by a ` (backtick) and a , (coma) I.e. `username`, `name`, `password`.
            $sql = "INSERT INTO {$table} (`" . implode('`,`' , $keys) . "`) VALUES ({$values})";

            // If there was not an error return $this.
            if(!$this->query($sql, $fields)->error()) 
            {
                // Returns the current object being worked with or handled at that time. 
                return true;
            }
        }

        // If all else fails return false.
        return false;
    }

    // Updates a given record within the database with a table an id and the fields.
    public function update($table, $id, $fields)
    {

        // Instantiated $set to and empty string.
        $set = '';

        // Instantiated $x to 1.
        $x = 1;

        // Loop through fields as name.
        foreach($fields as $name => $value)
        {
            // Bind "{$name} = ?" to $set.
            $set .= "{$name} = ?";
            
            // Checks if $x is less than the count of $fields and if it is.
            if($x < count($fields))
            {
                // Adds a , (coma) in between $set in the sql statement 
                // I.e. name, username WHERE id is equal to 10.
                $set .= ', ';
            }
            // Each loop throught the foreach will increment $x by ++ I.e. 1.
            $x++;
        }

        // SQL Statement.
        // I.e. sql is equal to the statement.
        // UPDATE table I.e. users SET set I.e. username WHERE id = id I.e. 10.
        $sql = "UPDATE {$table} SET {$set} WHERE userID = {$id}";

        // If there was not an error return $this.
        if(!$this->query($sql, $fields)->error())
        {
            // Returns the current object being worked with or handled at that time. 
            return true;
        }

        // If all else fails return false.
        return false;
    }

	  // Gets from a table Where = ?.
    public function get($table, $where)
  	{
        // Return from a table WHERE and some trest criteria.
        // Sets the action to SELECT *.
   		return $this->action('SELECT *', $table, $where);
  	}

    // Deletes from a table Where = ?
    public function delete($table, $where)
  	{
        // Return delete from a table WHERE and some trest criteria.
        // Sets the action to DELETE *.
    	return $this->action('DELETE', $table, $where);
  	}

    // Stored results, used in foreach statement primarily.
    // I.e. foreach($getLocation->results() as $location)
    // Stores results ready for data use.
    public function results()
    {
      return $this->_results;
    }

  	// Returns the first user in the array I.e. position [0] usually user with 0.
  	public function first()
  	{
  		return $this->results()[0];
  	}

  	// Return an error if one is needed or found.
    // I.e. no users found while querying the database for users.
    public function error()
  	{
    	return $this->_error;
  	}

  	// Counts all of the users in the database.
  	public function count()
  	{
    	return $this->_count;
  	}
}
?>