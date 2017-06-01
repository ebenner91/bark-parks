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
             <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
             </button>
              <a class="navbar-brand" href="#">BarkParks</a>
          </div>
         <!-- Collect the nav links, forms, and other content for toggling -->
         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">Create an Account</a></li>
              </ul>
        </div><!-- /.container-fluid -->
        </nav>
     
     
         <div class="container">
            <div class="col-sm-12 col-md-12 col-xl-12">
                 <div class="row">
                 <div class="col-sm-5"></div>
             <form class="navbar-form col-sm-6" role="search">
         <div class="input-group add-on">
              <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
              <div class="input-group-btn">
               <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
             </div>
         </div>
        </form>
       </div> <!-- end of row-->
     </div>
       <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Park</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <tr><!-- Loop for data should begin here-->
                  <td>ParkName1</td>
                  <td>ParkLocation1</td>
                  <td>3 out of 5</td>
                  <td>Picture of a Pencil.jpeg</td>
                </tr><!-- end of loop-->
            </tbody>
            
        </table>     
            
     </div>   
    </body>
</html>