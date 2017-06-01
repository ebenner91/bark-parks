<?php
    /*
    *Elizabeth Benner and Jeff Church
    *5/31/17
    *barkdb.php
    *This class provides access to the database for the bark-parks website
    */
    
    /**
     * Provides CRUD access to information in the database
     *
     * PHP Version 5
     *
     * @author Elizabeth Benner and Jeff Church
     * @version 1.0
     */
    

class BlogsDB
{
    private $_pdo;
    
    /**
     *Constructor to open the connection to the database
    */
    function __construct()
    {
        //Require configuration file
        require_once '/home/ebenner/config.php';
        
        try {
            //Establish database connection
            $this->_pdo = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            
            //Keep the connection open for reuse to improve performance
            $this->_pdo->setAttribute( PDO::ATTR_PERSISTENT, true);
            
            //Throw an exception whenever a database error occurs
            $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (PDOException $e) {
            die( "Error!: " . $e->getMessage());
        }
    }
    
    //Methods to access user information
    /**
     *Creates a user in the datatbase using a User object
     *
     *@access public
     *
     *@param Object $user a user object containing the username and password of the new user
     *
     *@return the database id of the new user
     */
    function addUser($user)
    {
        //Create the insert statement, setting the premium column to 1 to indicate a premium member
        $insert = 'INSERT INTO users (username, password)
        VALUES (:username, :password)';
        
        $statement = $this->_pdo->prepare($insert);

        $statement->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $statement->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        
        $statement->execute();
        
        //Return ID of inserted row
        return $this->_pdo->lastInsertId();
    }
    
    /**
    * Returns a user that matches the given id
    *
    * @access public
    * @param int $id the id of the user
    *
    * @return an associative array of user information
    */
   function getUserById($id)
   {
        //Create the select statement
       $select = 'SELECT id, username, password
                    FROM users WHERE id=:id';
       
       //prepare the statement and bind the id
       $statement = $this->_pdo->prepare($select);
       $statement->bindValue(':id', $id, PDO::PARAM_INT);
       $statement->execute();
       
       //return the array holding the info pulled from the database 
       return $statement->fetch(PDO::FETCH_ASSOC);
   }
    
    /**
    *Checks user credentials
    *
    *@param String username the username entered
    *@param String password the password entered
    *
    *@return boolean indiating whether the credentials matched
    */
   function login($username, $password)
   {
        $select = 'SELECT username, password
                    FROM users WHERE username=:username';
                    
        //prepare the statement and bind the id
        $statement = $this->_pdo->prepare($select);
        $statement->bindValue(':username', $username, PDO::PARAM_INT);
        $statement->execute();
        
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return password_verify($password, $result['password']);
   }
   
   //Methods to access park information
   
   