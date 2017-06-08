<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name ="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../styles/styles.css">
	<title>Bark Parks</title>
	</head>
    <body>
        
        
     <nav class="navbar navbar-default">
        <div class="container-fluid">
         <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
              <a class="navbar-brand" href="../">BarkParks</a>
          </div>
         <!-- Collect the nav links, forms, and other content for toggling -->
              <ul class="nav navbar-nav">
                <li><a href="../">Home</a></li>
                <li><a href="../login">Login</a></li>
                <li><a href="../newaccount">Create an Account</a></li>
              </ul>
        </nav>
        
        <div class="container">
            <div class="row park-name">
            <div class="col-sm-3">
                 <p class ="park-name"><?= $park['park_name'] ?></p>
            </div>
              <div class='row park_rating'>
					Rate:
					<div id="<?= $park['id'] ?>" class="rate_widget">
						<div class="star_1 ratings_stars"></div>
						<div class="star_2 ratings_stars"></div>
						<div class="star_3 ratings_stars"></div>
						<div class="star_4 ratings_stars"></div>
						<div class="star_5 ratings_stars"></div>
						<div class="total_votes">vote data</div>
					</div>
				</div>  
           </div>
            <div class="row features">
                <div class="col-sm-4">
                <h3>Features:</h3>         
				<ul>
				<?php foreach (($park['features']?:[]) as $feature): ?>
					<li><?= $feature ?></li>
				<?php endforeach; ?>
				</ul>
                </div>
                <div class="col-sm-8">
                    <img src="../images/freja.PNG" class="featuredpics">
					<img src="../images/freja.PNG" class="featuredpics">
					<img src="../images/freja.PNG" class="featuredpics">
					
                </div>
            </div>
            <div class="row about-park">
                <div class="col-sm-6">
                    <h3>Description:</h3><br/>
                    <?= $park['description'].PHP_EOL ?>
                </div>
                <div class="col-sm-6">
                    <h3>Comments:</h3><br/>
                    Commentstextwillgohere.
                </div>
            </div>
        </div>
     
   
            
     </div>
		<script
		src="https://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		crossorigin="anonymous"></script>
		<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<script src="../scripts/script.js"></script>
    </body>
</html>