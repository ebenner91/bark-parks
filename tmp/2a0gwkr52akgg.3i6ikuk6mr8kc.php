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
					
						<li class="active"><a href="./logout">Logout <span class="sr-only">(current)</span></a></li>
					
					<?php else: ?>
						<li class="active"><a href="./login">Login <span class="sr-only">(current)</span></a></li>
					
				<?php endif; ?>
				<?php if ($SESSION['loggedin'] == true): ?>
					
					<?php else: ?><li><a href="./newaccount">Create an Account</a></li>
				<?php endif; ?>
              </ul>
        </nav>
        
        <div class="container">
            <div class="row">
                <div class="center">
                    <h4>Welcome!</h4>
                    <hr>
                     <form class="form-horizontal" method="post" action="./login">
                       <div class="form-group">
                         <label class="control-label col-sm-2" for="email">Email:</label>
                         <div class="col-sm-10">
                           <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                         </div>
                       </div>
                       <div class="form-group">
                         <label class="control-label col-sm-2" for="password">Password:</label>
                         <div class="col-sm-10"> 
                           <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                         </div>
                       </div>
                       <div class="form-group"> 
                       </div>
                       <div class="form-group"> 
                         <div class="col-sm-offset-2 col-sm-10">
                           <button type="submit" class="btn btn-default btn-center">Sign in</button>
							<?php if ($loginSuccess): ?>
								<?php else: ?><div>Login failed, check email & password.</div>
							<?php endif; ?>
                         </div>
                       </div>
                     </form>
                </div>
            
           </div> 
        </div>
     
   
            
     </div>   
    </body>
</html>