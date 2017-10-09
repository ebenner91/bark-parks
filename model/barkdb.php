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

        $statement->bindValue(':admin_key', password_hash($key, PASSWORD_DEFAULT), PDO::PARAM_STR);
        
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
        
        if($result['num_ratings'] != 0) {
            $result['rating'] = floor($result['sum_ratings'] / $result['num_ratings']);
        } else {
            $result['rating'] = 0;
        }
        
        $result['features'] = explode(', ', $result['features']);
        
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
        
        foreach($results as &$row) {
             if($row['num_ratings'] != 0) {
                 $row['rating'] = floor($row['sum_ratings'] / $row['num_ratings']);
             } else {
                 $row['rating'] = 0;
             }
             
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
        SET sum_ratings = sum_ratings + :new_rating, num_ratings = num_ratings + 1
        WHERE id = :id';
        
        $statement = $this->_pdo->prepare($update);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':new_rating', $newRating, PDO::PARAM_INT);
        
        $statement->execute();
        
        
   }
   
   /**
    *Fetches the rating info for the database
    *
    *@access public
    *@param int $id the id of the park whose ratings are being retrieved
    *
    *@return an associative array containing the rating info
    */
   function getRating($id)
   {
        $select = 'SELECT id, num_ratings, sum_ratings
                    FROM parks WHERE id=:id';
                    
        $statement = $this->_pdo->prepare($select);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
         
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($result['num_ratings'] != 0) {
            $result['avg_rating'] = floor($result['sum_ratings'] / $result['num_ratings']);
        } else {
            $result['avg_rating'] = 0;
        }
        
        return $result;
   }
   
   
   /**
    *Adds a feature to the features list by pulling the list from the database,
    *adding the new feature to the list, then updating the list in the database with the
    *new list
    *
    *@param int $id the id of the park to be updated
    *@param String $newFeature the new feature to be added to the list
    *@return boolean true if feature added successfully, false if not
    */
   function addFeature($id, $newFeatures)
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
        
        $newFeatures = explode(', ', $newFeatures);
        
        if(count($newFeatures > 1)) {
            foreach($newFeatures as $newFeature) {
                //Validate that feature is not already in array
                if(in_array($newFeature, $featuresArray)) {
                    //If already in array, do not add feature, return false
                    return false;
                } else {
                    
                    //Push the new feature onto the array
                    $featuresArray[] = $newFeature;
                }
            }
        } else {
           $featuresArray = array_merge($featuresArray, $newFeatures);
        }
            
        //Implode the list back into a String
        $featuresList = implode(', ', $featuresArray);
        
        //Create the update statement
        $update = 'UPDATE parks
        SET features = :features
        WHERE id = :id';
        
        $statement = $this->_pdo->prepare($update);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':features', $featuresList, PDO::PARAM_STR);
        
        $statement->execute();
        
        //Feature(s) added successfully, return true
        return true;
        
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
   
   /**
    *Retrieves the comments for a given park
    *
    *@param int $id the id of the park whose comments are to be returned
    *@return an associative array holding the comments for the given park
    */
   function getComments($id)
   {
        $select = 'SELECT id, park_id, text, username, date_posted
                    FROM comments WHERE park_id = :park_id ORDER BY date_posted';
                    
        $statement = $this->_pdo->prepare($select);
        $statement->bindValue(':park_id', $id, PDO::PARAM_INT);
         
        $statement->execute();
         
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
   }
   
   /**
    *Retrieves the image paths for a given park
    *
    *@param int $id the id of the park whose images are being returned
    *@return an associative array holding the image paths for the given park
    */
   function getImages($id)
   {
        $select = 'SELECT id, parkid, image_path
                    FROM images WHERE parkid = :parkid';
                    
        $statement = $this->_pdo->prepare($select);
        $statement->bindValue(':parkid', $id, PDO::PARAM_INT);
         
        $statement->execute();
         
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;
   }
   
   /**
    *Adds an image filepath to the database
    *
    *@param int $parkId the id of the park associated with the photo
    *@param String $filePath the file path for the image being uploaded
    */
   function addPhoto($parkId, $filePath)
   {
        //Create the insert statement
        $insert = 'INSERT INTO images (parkid, image_path)
        VALUES (:parkid, :image_path)';
        
        $statement = $this->_pdo->prepare($insert);

        $statement->bindValue(':parkid', $parkId, PDO::PARAM_INT);
        $statement->bindValue(':image_path', $filePath, PDO::PARAM_STR);
        
        $statement->execute();
   }
   
   /**
    *Adds a comment to the database
    *
    *@param String $comment the text of the comment to be added
    *@param String $username the username of the user submitting the comment
    *@param int $parkId, the id of the park the comment is being submitted on
    */
   function addComment($comment, $username, $parkId)
   {
        //Create the insert statement
        $insert = 'INSERT INTO comments (parkid, text, username, date_posted)
        VALUES (:parkid, :text, :username, NOW())';
        
        $statement = $this->_pdo->prepare($insert);

        $statement->bindValue(':parkid', $parkId, PDO::PARAM_INT);
        $statement->bindValue(':text', $comment, PDO::PARAM_STR);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        
        $statement->execute();
        
        //Comment added successfully, return true
        return true;
   }
   
}
   
   