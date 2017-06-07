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
    

class BarkDB
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
     *Creates a basic user in the database using a User object
     *
     *@access public
     *
     *@param Object $user a user object containing the username and password of the new user
     *
     *@return the database id of the new user
     */
    function addBasicUser($user)
    {
        //Create the insert statement
        $insert = 'INSERT INTO users (username, password, delete_parks, delete_photos, delete_comments)
        VALUES (:username, :password, 0, 0, 0)';
        
        $statement = $this->_pdo->prepare($insert);

        $statement->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $statement->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        
        $statement->execute();
        
        //Return ID of inserted row
        return $this->_pdo->lastInsertId();
    }
    
    /**
     *Creates an administrative user in the database using an AdminUser object
     *
     *@access public
     *
     *@param Object $user an AdminUser object containing username, password, and an array of permissions
     *
     *@return the database id of the new user
     */
    function addAdmin($user)
    {
        //Create the insert statement
        $insert = 'INSERT INTO users (username, password, delete_parks, delete_photos, delete_comments)
        VALUES (:username, :password, :delete_parks, :delete_photos, :delete_comments)';
        
        $statement = $this->_pdo->prepare($insert);
        
        //Process permissions array
        $permissions = $user->getPermissions();
        if(isset($permissions['parks'])) {
            $deleteParks = 1;
        } else {
            $deleteParks = 0;
        }
        if(isset($permissions['photos'])) {
            $deletePhotos = 1;
        } else {
            $deletePhotos = 0;
        }
        if(isset($permissions['comments'])) {
            $deleteComments = 1;
        } else {
            $deleteComments = 0;
        }

        $statement->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $statement->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $statement->bindValue(':delete_parks', $deleteParks, PDO::PARAM_INT);
        $statement->bindValue(':delete_photos', $deletePhotos, PDO::PARAM_INT);
        $statement->bindValue(':delete_comments', $deleteComments, PDO::PARAM_INT);
        
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
       $select = 'SELECT id, username, password, delete_parks, delete_photos, delete_comments
                    FROM users WHERE id=:id';
       
       //prepare the statement and bind the id
       $statement = $this->_pdo->prepare($select);
       $statement->bindValue(':id', $id, PDO::PARAM_INT);
       $statement->execute();
       
       //return the array holding the info pulled from the database 
       return $statement->fetch(PDO::FETCH_ASSOC);
   }
   
   /**
    *Sets a key to allow users to create admin accounts
    *
    *@acess public
    *@param String $key the secret key that users can enter to set up admin access
    */
   function setAdminKey($key)
   {
        //Create the insert statement
        $insert = 'INSERT INTO parkadmin (admin_key)
        VALUES (:admin_key)';
        
        $statement = $this->_pdo->prepare($insert);

        $statement->bindValue(':admin_key', password_hash($key), PDO::PARAM_STR);
        
        $statement->execute();
    
    
   }
   
   /**
    *Verifies the admin key
    *
    *@access public
    *@param String $key the given key to be verified
    *
    *@return boolean True if the key is a match, false if not
    */
   function checkAdminKey($key)
   {
        $select = 'SELECT key
                    FROM parkadmin WHERE id = 1';
                    
        //prepare the statement and bind the id
        $statement = $this->_pdo->prepare($select);
        $statement->execute();
        
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return password_verify($key, $result['admin_key']);
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
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        return password_verify($password, $result['password']);
   }
   
   /**
    *Updates a user's password
    *
    *@param String $password the new password to be entered
    *@param int $id the id of the user to be updates
    */
   function changePassword($password, $id)
   {
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $update = 'UPDATE users
        SET password = :password
        WHERE id = :id';
        
        $statement = $this->_pdo->prepare($update);
        $statement->bindValue(':password', $password, PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        $statement->execute();
        
   }
   
   //Methods to access park information
   
   /**
     *Creates a park in the database using a Park object
     *
     *@access public
     *
     *@param Object $park a Park object containing the information about the new park
     *
     *@return the database id of the new park
     */
    function addPark($park)
    {
        //Create the insert statement
        $insert = 'INSERT INTO parks (park_name, location, features, description)
        VALUES (:park_name, :location, :features, :description)';
        
        $statement = $this->_pdo->prepare($insert);

        $statement->bindValue(':park_name', $park->getName(), PDO::PARAM_STR);
        $statement->bindValue(':location', $park->getLocation(), PDO::PARAM_STR);
        $statement->bindValue(':features', $park->getFeatures(), PDO::PARAM_STR);
        $statement->bindValue(':description', $park->getDescription(), PDO::PARAM_STR);
        
        $statement->execute();
        
        //Return ID of inserted row
        return $this->_pdo->lastInsertId();
    }
    
    /**
    * Returns a park that matches the given id
    *
    * @access public
    * @param int $id the id of the park
    *
    * @return an associative array of park information
    */
   function getParkById($id)
   {
        //Create the select statement
        $select = 'SELECT id, park_name, location, num_ratings, sum_ratings, features, description
                    FROM parks WHERE id=:id';
       
        //prepare the statement and bind the id
        $statement = $this->_pdo->prepare($select);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        $result['rating'] = intdiv($result['sum_ratings'], $result['num_ratings']);
        
        //return the array holding the info pulled from the database 
        return $result;
   }
   
   /**
    *Returns an associative array containing all of the parks in the database
    *
    *@return an associative array of all of the parks with their information
    */
   function getAllParks()
   {
        $select = 'SELECT id, park_name, location, num_ratings, sum_ratings, features, description
                    FROM parks ORDER BY park_name';
                    
       $statement = $this->_pdo->prepare($select);
        
       $statement->execute();
        
       $results = $statement->fetchAll(PDO::FETCH_ASSOC);
       
       foreach($results as $row) {
            $row['rating'] = intdiv($row['sum_ratings'], $row['num_ratings']);
       }
       
       return $results;
   }
   
   /**
    *Updates rating stats on a park
    *
    *@access public
    *@param int $id the id of the park
    *@param $newRating the new rating to add to the data
    */
   function updateRating($id, $newRating)
   {
        //Create the update statement
        $update = 'UPDATE parks
        SET sum_rating = sum_rating + :new_rating, num_rating = num_rating + 1
        WHERE id = :id';
        
        $statement = $this->_pdo->prepare($update);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':new_rating', $newRating, PDO::PARAM_INT);
        
        $statement->execute();
        
        
   }
   
   
   /**
    *Adds a feature to the features list by pulling the list from the database,
    *adding the new feature to the list, then updating the list in the database with the
    *new list
    *
    *@param int $id the id of the park to be updated
    *@param String $newFeature the new feature to be added to the list
    */
   function addFeature($id, $newFeature)
   {
        //Select the current features list from the database
        $select = 'SELECT features
                    FROM parks WHERE id=:id';
       
        //prepare the statement and bind the id
        $statement = $this->_pdo->prepare($select);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        //Save the features into a String
        $featuresList = $result['features'];
        
        //Explode the list into an array
        $featuresArray = explode(', ', $featuresList);
        
        //Push the new feature onto the array
        $featuresArray[] = $newFeature;
        
        //Implode the list back into a String
        $featuresList = implode(', ', $featuresList);
        
        //Create the update statement
        $update = 'UPDATE parks
        SET features = :features
        WHERE id = :id';
        
        $statement = $this->_pdo->prepare($update);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':features', $featuresList, PDO::PARAM_STR);
        
        $statement->execute();
        
   }
   
   /**
    *Updates the park description
    *
    *@param int $id the id of the park to be updated
    *@param String $description the new description for the park
    */
   function updateDescription($id, $description)
   {
        //Create the update statement
        $update = 'UPDATE parks
        SET description = :description
        WHERE id = :id';
        
        $statement = $this->_pdo->prepare($update);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':description', $description, PDO::PARAM_STR);
        
        $statement->execute();
   }
   
   
   
   