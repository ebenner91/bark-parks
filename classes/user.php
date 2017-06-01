<?php
    /*
    *Elizabeth Benner and Jeff Church
    *5/30/17
    *user.php
    *The User class represents a registered user of bark-parks
    */

    /**
    * The User class represents a registered user of bark parks
    *
    * The User class represents a registered user of bark parks,
    * it stores username and password
    * @author Elizabeth Benner
    * @author Jeff Church
    * @copyright 2017
    *
    */
    
    class User
    {
        protected $username;
        protected $password;
        
        /**
         *Contructor to create the user and save the details
         *
         *@param String $username the user's login name
         *@param String $password the user's plain text password, which will be saved as a hash
         */
        function __construct($username, $password)
        {
            $this->username = $username;
            $this->password = password_hash($password);
        }
        
        //Setters
        /**
         *Setter for the username
         *
         *@param String $username the user's login name
         */
        function setUsername($username)
        {
            $this->username = $username;
        }
        
        /**
         *Setter for the password
         *
         *@param String $password the user's plain text password, which will be saved as a hash
         */
        function setPassword($password)
        {
            $this->password = password_hash($password);
        }
        
        //Getters
        /**
         *Getter for the username
         *
         *@return String the user's login name
         */
        function getUsername()
        {
            return $this->username;
        }
        
        /**
         *Getter for the password
         *
         *@return String the user's hashed password
         */
        function getPassword()
        {
            return $this->password;
        }