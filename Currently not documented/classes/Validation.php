<?php
// This class gives the ability to multiple things I.e. 
// if all register fields are populated, if password match 
// and min max values for inpout fields.

// It is built it in such a way that it is not sight specific
// and can be used with any registration page (If the field variable match I.e.)
// name, username, password, password_again (see register.php).
class Validation
{
	// Private variables
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	// Retrieves/constructs an instance of the database.
	public function __construct()
	{
		$this->_db = DatabaseConnectivity::getInstance();
	}

	// A method that allows us to check multiple things I.e
	// If all of the fields have got data in them, 
	// if the data entered (username) already exists in the database,
	// if both password fields have data and if that data matches
	// if any of these queries fail then the user is not created
	// and the user does not get granted access to the system.
	public function validateCheck($source, $items = array())
	{
		foreach($items as $item => $rules)
		{
			foreach($rules as $rule => $rule_value)
			{
				$value = trim($source[$item]);
				$item = escape($item);

				// Check if a required field has data I.e. returns empty.
				if($rule === 'required' && empty($value))
				{
					// If a field returns empty then an error is added.
					$this->addError("{$item} is required.");

				}else if(!empty($value))
				{
					// Switch statement to enable checks for multiple criteria.
					// I.e. min, max, matches, unique.
					switch($rule)
					{
					// Ensures the user cannot input less than the minimum allowed amount of chacters.
					case 'min':
						if(strlen($value) < $rule_value)
						{
							$this->addError("{$item} must be a minimum of {$rule_value} characters.");
						}
					break;

					// Ensures the user cannot input more than the maximum allowed amount of chacters.
					case 'max':
						if(strlen($value) > $rule_value)
						{
							$this->addError("{$item} must be a maximum of {$rule_value} characters.");
						}
					break;

					// Checks if two fields match I.e. password, password_again.
					case 'matches':
						if($value != $source[$rule_value])
						{
							$this->addError("{$rule_value} must match {$item}.");
						}
					break;

					// Check if the data inputed already exists in the database I.e. username.
					case 'unique':
						$check = $this->_db->get($rule_value, array($item, '=', $value));
						if ($check->count()) 
						{
                			$this->addError("{$item} already exists.");
						}
					break;
					}
				}
			}
		}

		
		// If no errors occured let it pass I.e. 
		// if errors is empty then there was no error
		// so let it pass.
		if (empty($this->_errors)) 
		{
      	$this->_passed = true;
    	}
    	return $this;
  	}

  	// Adds an error to the errors array.
	public function addError($error)
  	{
    	$this->_errors[] = $error;
  	}

  	// Error function.
  	public function errors()	
  	{
    	return $this->_errors;
  	}

  	// Validation passed function.
  	public function passed()
  	{
   		return $this->_passed;
  	}
}
?>