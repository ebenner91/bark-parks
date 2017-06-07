<?php
	
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
        $view = new View;
        echo Template::instance()->render('pages/newaccount.html');
    });     
    
    
    $f3->route('GET /viewpark', function($f3) {
        $view = new View;
        echo Template::instance()->render('pages/viewpark.html');
    });         
        //Run fat free    
    $f3->run();
    
?>  