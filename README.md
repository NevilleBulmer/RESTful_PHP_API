# RESTful PHP API along with an angular js front end example.

A RESTful API built using vanilla PHP.
See explanantions below for more information.

Files will be uploaded once they are all complete.

The API is designed to be used in many contexts and with this in mind it returns and send all information in JSON, below is a representation of the file structure along with an explanation of the end points.

Along with an API, provided is an angular js front end example, this is to serve the purpouse of providing a full and concise example.

* config
  * Configuration.php
* Part One

  * API
      * Accounts
        * Login
          * index.php
          * POST
          * http://localhost/W17019469/part1/api/accounts/login/index.html
        * logout
          * index.php
          * POST
          * http://localhost/W17019469/part1/api/accounts/logout/index.html
        * signup
          * index.php
          * POST
          * http://localhost/W17019469/part1/api/accounts/signup/index.html
        * Presentations
          * Category
            * Index.php
            * GET
            * http://localhost/W17019469/part1/api/presentations/category/index.html
          * Create
            * Index.php
            * POST
            * http://localhost/W17019469/part1/api/presentations/create/index.html
          * Remove
            * Index.php
            * POST
            * http://localhost/W17019469/part1/api/presentations/remove/index.html
          * Search
            * Index.php
            * POST
            * http://localhost/W17019469/part1/api/presentations/search/index.html
          * Schedule
            * Index.php
            * GET
            * http://localhost/W17019469/part1/api/schedule/index.html
          * search
            * index.php
            * POST
            * http://localhost/W17019469/part1/api/schedule/search/index.html
    * Index.php
  * Classes
    * CheckInput.php
    * Configuration.php
    * DatabaseConnectivity
    * DatabaseWrapplet.php
    * HashGenerator.php
    * Redirect.php
    * Session.php
    * Token.php
    * Validation.php
    
  * Database (If using SQLite)
    * database.sqlite
    
  * local-html
    * about (This is where you should hold your about page)
    * documentation (This is where you should hold your documentation page)
    * templates (If using OOP PHP, this is where you should hold you header, footer and main.php)
    * index.php


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

### Class DatabaseWrapplet.php
Explanation and upload to come.

### Class Configuration.php
Explanation and upload to come.

### Class SanitizeString.php
Explanation and upload to come.

### Class Session.php
Explanation and upload to come.


### More to come.
