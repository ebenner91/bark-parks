<?php
	/**
	 * ebenner. | jchurch.greenrivertech.net/328/bark-parks
	 * Elizabeth Benner and Jeff Church
	 * Final Project - Bark-Parks dog park finder
	 * 6/13/17
	 * Controller for Bark-Parks website
	 */
	
	/**
	* This is the controller for the bark-parks website
	*
	* The controller directs the various routes of the website, directing users
	* to various pages, as well as passing entered information between the pages and
	* to and from the server using a PDO class.
	* Also handles POST routes for ajax calls on the website
	* @author Elizabeth Benner and Jeff Church
	* @copyright 2017
	*
	*/
    //require the autoload file
    require_once('vendor/autoload.php');
	session_start();
    //create an instance of the Base class
    $f3 = Base::instance();
    $f3->set('DEBUG', 3);
    
    //Instantiate the database class
	$barkDB = new BarkDB();
    
	
    $f3->route('GET /', function($f3) {
        $parks = $GLOBALS['barkDB']->getAllParks();
        $f3->set("parks", $parks);
        
        echo Template::instance()->render('pages/home.html');
    });
      
    $f3->route('GET /login', function($f3) {
        $view = new View;
        echo Template::instance()->render('pages/login.html');
    });
	
    $f3->route('POST /login', function($f3) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$barkDB = $GLOBALS['barkDB'];
		if($barkDB->login($username, $password)){
			$f3->set("SESSION.loggedin",  true);
			echo "header('Location: ../)";
		}
        $view = new View;
        echo Template::instance()->render('pages/login.html');
    });        
    
    
    $f3->route('GET /newaccount', function($f3) {
        $view = new View;
        echo Template::instance()->render('pages/newaccount.html');
    });
	
    $f3->route('POST /newaccount', function($f3) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$key = $_POST['key'];

		if($password == $password2){
			if(isset($_POST['admin'])){
			//create admin account
		}
		else{
			//make normal account
		}
		}
		
        $view = new View;
        echo Template::instance()->render('pages/newaccount.html');
    });
    
    
    $f3->route('GET|POST /viewpark/@id', function($f3, $params) {
		if(isset($_POST['photo-submit']))
		{
			//Validate image upload
			//Check for upload errors
			if($_FILES['image']['error'] > 0) {
				$f3->set("uploadErrors", true);
				$f3->set("photoErrorText", "An error occured while uploading, please try again or try another image");
			} else if($_FILES['image']['size'] > 500000) {
				//Max file size of 500kb
				$f3->set("uploadErrors", true);
				$f3->set("photoErrorText", "Image too large, please do not upload images larger than 500kb");
			} else if(file_exists('/328/bark-parks/images/' . $_FILES['image']['name'])) {
				//Check if file already exists
				$f3->set("uploadErrors", true);
				$f3->set("photoErrorText", "A file by that name already exists, please change the name or upload a different image");
			} else {
				//Upload file and add to database
				move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . basename($_FILES["image"]["name"]));
				$filename = basename($_FILES["image"]["name"]);
				$url = "/328/bark-parks/images/$filename";
				$GLOBALS['barkDB']->addPhoto($params['id'], $url);
				$f3->set("imageSuccess", true);
				$f3->set("photoSuccessText", "Image Uploaded Successfully!");
			}
		}
		if(isset($_POST['feature-submit'])) {
			if($GLOBALS['barkDB']->addFeature($params['id'], $_POST['features'])) {
				$f3->set('featureSuccess', true);
				$f3->set('featureSuccessText', 'Feature(s) submitted successfully!');
			} else {
				$f3->set('featureSuccess', false);
				$f3->set('featureErrorText', 'One or more of your features was already on file, please try again');
			}
		}
		if(isset($_POST['comment-submit'])) {
			if($GLOBALS['barkDB']->addComment($_SESSION['username'], $_POST['comment'],$params['id'])) {
				$f3->set('commentSuccess', true);
				$f3->set('commentSuccessText', 'Comment submitted successfully!');
			} else {
				$f3->set('commentSuccess', false);
				$f3->set('commentErrorText', 'Unable to submit comment, please try again.');
			}
		}
		$park =  $GLOBALS['barkDB']->getParkById($params['id']);
		$comments = $GLOBALS['barkDB']->getComments($params['id']);
		$images = $GLOBALS['barkDB']->getImages($params['id']);
		$f3->set('park', $park);
		$f3->set('comments', $comments);
		$f3->set('images', $images);
		
        echo Template::instance()->render('pages/viewpark.html');
    });
	
	$f3->route('POST /ratings', function($f3) {
		$widget_id = $_POST['widget_id'];
		
		if(isset($_POST['fetch'])) {
			echo json_encode($GLOBALS['barkDB']->getRating($widget_id));
		} else {
			//Get the value of the vote
			preg_match('/star_([1-5]{1})/', $_POST['clicked_on'], $match);
			$vote = $match[1];
			
			$GLOBALS['barkDB']->updateRating($widget_id, $vote);
			echo json_encode($GLOBALS['barkDB']->getRating($widget_id));
		}
    });
	
	$f3->route('GET|POST /newpark', function($f3) {
		
        echo Template::instance()->render('pages/newpark.html');
    });
        //Run fat free    
    $f3->run();
    
?>  