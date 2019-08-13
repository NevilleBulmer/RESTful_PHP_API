# Database-Wrapper-In-PHP
An example of a database wrapper built in PHP, comes with helper classes, I.e. for sanitizing strings, checking user input and generating hashes.

Files will be uploaded once they are all complete.


### Class CheckInput.
Checks is the input is POST or GET.

### Class Redirect.php
Used to redirect from one page to another, also check if the location will result in a 404 or 403 error.

### Class Token.php
Used for generating unique tokens, This is the perfect solution for preventing cross site scripting attacks.

### Class Validation.php
Used for custom validation, I.e. is the username provided too long, short or does it meet the certain criteria.
Can be used for any user input, I.e. does the email meet the criteria needed, I.e. is there an @ symbol present, does it end with .com, .co.uk so on and so forth.

### Class HashGenerator.php
Used for creating hashes, salts and/or generating password hashes in there entirety, I.e. the database would store the password hash, the salt and when the user goes to login this information would be used to authenticate the user.

### Class DatabaseConnectivity.php
Utilising the singletone pattern, this is a database wrapplet class which abstracts all information for use with multiple databases and tables, this is acomplished by the abstraction, as using this technique there is no identifying information in this class, instead everything is held as a variable.
