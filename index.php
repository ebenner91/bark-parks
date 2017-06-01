<?php

    //require the autoload file
    require_once('vendor/autoload.php');
    //create an instance of the Base class
    $f3 = Base::instance();
    $f3->set('DEBUG', 3);
    
    $f3->route('GET /', function($f3) {
        $view = new View;
        echo Template::instance()->render('pages/home.html');
    });
      
    $f3->route('GET /login', function($f3) {
        $view = new View;
        echo Template::instance()->render('pages/login.html');
    });
        
    
    
    $f3->route('GET /newaccount', function($f3) {
        $view = new View;
        echo Template::instance()->render('pages/newaccount.html');
    });    
        
        //Run fat free    
    $f3->run();
    
?>  