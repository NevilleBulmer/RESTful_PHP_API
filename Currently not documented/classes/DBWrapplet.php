<?php    
class DBWrapplet
{
	// Instantiated private variables.
	private $_db,
			$_data,
			$_sessionName,
			$_isLoggedIn;


	public function __construct($DBWrapplet = null)
	{
		// Sets _db equal to an instance of the database connection 
		// I.e. DatabaseConnectivity::getInstance();.
		$this->_db = DatabaseConnectivity::getInstance();

		// Sets _sessionName equal to an instance of the current session
		// I.e. Configuration::getConfiguration('session/session_name');.
		$this->_sessionName = Configuration::getConfiguration('session/session_name');

		// If not connected.
		if(!$DBWrapplet)
		{
			// If session I.e. session name exists.
			if(Session::exists($this->_sessionName))
			{
				// Set $DBWrapplet to session get/return session I.e. session name.
				$DBWrapplet = Session::get($this->_sessionName);

				// If session I.e. session name is found.
				if($this->find($DBWrapplet))
				{
					// Return the user is logged in, equal to true
					$this->_isLoggedIn = true;
				}
			}
		}else
		{
			// If the above if statement didnt succefully find the session I.e. $DBWrapplet
			// then retry finding it and start again.
			$this->find($DBWrapplet);
		}
	}

	// Finds an entry based on numeric data with a backup of username.
	// I.e. user with ID 10, username Neville.
	public function find($DBWrapplet = null)		
	{
		// If connected.
		if($DBWrapplet)
		{
			// Set field equal to numeric I.e. either an ID or a username I.e. a nmc_users ID (10)
			// of a username (Neville).
			$field = (is_numeric($DBWrapplet)) ? 'userID' : 'email';

            // Sets data eqaul to get nmc_users were a field I.e. an ID or username 
			// is eqaul to what was found above.
			$data = $this->_db->get('hyldu_users', array($field, '=', $DBWrapplet));

			// If data counts.
			if($data->count())
			{
				// Set _data to the first record found as it is allways going to be the user
				// required.
				$this->_data = $data->first();

				// Return true if all worked out well.
				return true;
			}
		}
		// If all else failes return false.
		return false;
	}

	// Logs a user in by checking there entered information against the database 
	// and if a match is found the the user is logged in.
	public function login($email = null, $passwordHash = null)
	{
		// Finds the email associated with the user attempting to login.
        $DBWrapplet = $this->find($email);

		// If the email was found then it will attempt to verify the passwordHash.
		if($DBWrapplet)
		{
			// If the given plain text passwordHash is equal to the salted and hashed passwordHash stored in the
			// database which also corresponds the to user with the given email then. 
			if($this->data()->passwordHash === HashGenerator::makeHash($passwordHash, $this->data()->salt))
			{
				// Generate a session for that user.
				Session::put($this->_sessionName, $this->data()->userID);
				
				// If all of the above has worked correctly and the user entered there
				// details correctly then it will return true.
				return true;
			}
		}
		return false;
	}


	// Checks if the user logged in has admin permission, it does this by cheching the
	// groups table anbd then checking the grouping column in nmc_users to see if there
	// is a flag set I.e. 1, 2.

	// 1 is a standard user
	// 2 is an admin user
	public function userHasPermission($key)
	{
		// Instantiated group to get the fourp associated with the user id using the 
		// grouping column in the nmc_users table, the groups are set in the groups table.
		$group = $this->_db->get('groups', array('id', '=', $this->data()->grouping));

		// count throught the group I.e. the above assignment of group.
		if($group->count())
		{
			// Using a JSON string in the groups table I.e. admin = 2, normal user = 1.
			// It detects the current nmc_users permissions.
			$permissions = json_decode($group->first()->permission, true);

			// If permission/$key is equal to true I.e. the user has permission.
			if($permissions[$key] == true)
			{
				// Return true.
				return true;
			}
		}
		// If all else failes return false.
		return false;
	}

	// If an entry in the mysql database, table user
	// cant be updated then an error is thrown.
	public function updateUser($fields = array(), $id = null)
	{
		// If the user wanting to update is not logged in then set $id equal to id.
		if(!$id && $this->isLoggedIn())
		{
			// Sets $id equal to userID.
            $id = $this->data()->userID;
		}

		// If update collab_users where id and fields did not update then
		// throw a new exception.
		if(!$this->_db->update('hyldu_users', $id, $fields))
		{
			// Throw a new exception.
			throw new Exception('There was a problem with the update!!!');
		}
	}

	// If an entry in the mysql database, table user
	// cant be created then an error is thrown.
	public function createUser($fields)
	{
		// If insert nmc_users where fields did not create a new user then
		// throw a new exception.
		if(!$this->_db->insert('hyldu_users', $fields)) 
		{
			// Throw a new exception.
			throw new Exception('There was a problem creating a user!!!');
		}
    }
    
    // If an entry in the mysql database, table user
	// cant be created then an error is thrown.
	public function createProject($fields)
	{
		// If insert nmc_users where fields did not create a new user then
		// throw a new exception.
		if(!$this->_db->insert('projects', $fields)) 
		{
			// Throw a new exception.
			throw new Exception('There was a problem creating the project!!!');
		}
    }
    
    // If an entry in the mysql database, table user
	// cant be created then an error is thrown.
	public function createPortfolioEntry($fields)
	{
		// If insert nmc_users where fields did not create a new user then
		// throw a new exception.
		if(!$this->_db->insert('users_portfolio', $fields)) 
		{
			// Throw a new exception.
			throw new Exception('There was a problem creating the project!!!');
		}
	}

    // If an entry in the mysql database, table user
	// cant be created then an error is thrown.
	public function addNewsletterContact($fields)
	{
		// If insert nmc_users where fields did not create a new user then
		// throw a new exception.
		if(!$this->_db->insert('newsletter_contact', $fields)) 
		{
			// Throw a new exception.
			throw new Exception('There was a problem while signing you up!!!');
		}
    }
    
    // If an entry in the mysql database, table user
	// cant be created then an error is thrown.
	public function addContactMessage($fields)
	{
		// If insert nmc_users where fields did not create a new user then
		// throw a new exception.
		if(!$this->_db->insert('contact_message', $fields)) 
		{
			// Throw a new exception.
			throw new Exception('There was a problem while signing you up!!!');
		}
	}

	// Logs the user out by deleting there current session.
	public function logout()
	{
		// Logout just deletes the current session.
		Session::delete($this->_sessionName);
	}

	// Returns data.
	public function data()
	{
		// Returns the data collected and stored.
		return $this->_data;
	}

	// Checks if the user is logged in.
	// This can and is used tyo check if the user is logged.
	public function isLoggedIn()
	{
		// Return wether or not the user is logged in.
		// Used to test permissions mainly and restrict 
		// access if the user is not logged in.
		return $this->_isLoggedIn;
	}
}
?>