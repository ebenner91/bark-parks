<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name ="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles/styles.css">
	<title>Bark Parks</title>
	</head>
    <body>
        
        
     <nav class="navbar navbar-default">
        <div class="container-fluid">
         <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
              <a class="navbar-brand" href="./">BarkParks</a>
          </div>
         <!-- Collect the nav links, forms, and other content for toggling -->
              <ul class="nav navbar-nav">
                <li><a href="./">Home</a></li>
                <?php if ($SESSION['loggedin'] == true): ?>
					
						<li><a href="./logout">Logout</a></li>
					
					<?php else: ?>
						<li><a href="./login">Login</a></li>
					
				<?php endif; ?>
                <li><a href="./newaccount">Create an Account</a></li>
              </ul>
        </nav>
        
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="center col-sm-6">
                    <h4>Add a New Park:</h4>
                    <hr>
                     <form class="form-horizontal" method="post" action="./newpark">
                       <div class="form-group">
                         <label class="control-label col-sm-2" for="name">Name:</label>
                         <div class="col-sm-10">
                           <input name="park-name" type="text" class="form-control" id="name" placeholder="Enter Park Name">
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="control-label col-sm-2" for="location">Location:</label>
                         <div class="col-sm-10"> 
                           <input name="location" type="text" class="form-control" id="location" placeholder="Enter Park Location">
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="control-label col-sm-2" for="features">Features:</label>
                         <div class="col-sm-10"> 
                           <textarea name="features" type="text" class="form-control" id="features" placeholder="Enter Park Features"></textarea>
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="control-label col-sm-2" for="description">Description:</label>
                         <div class="col-sm-10"> 
                           <textarea name="description" type="text" class="form-control" id="description" placeholder="Enter Park Description"></textarea>
                         </div>
                       </div>
                       <div class="form-group">
                         <div class="col-sm-offset-2 col-sm-10">
                           <button name="park-submit" type="submit" class="btn btn-default btn-center">Submit</button>
                         </div>
                       </div>
                     </form>
					 <?php if ($parkSuccess): ?>
						<?php else: ?><br><span class="text-danger"><?= $parkErrorText ?></span>
					<?php endif; ?>
                </div>        
           </div> 
        </div>
     </div>   
    </body>
</html>