<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name ="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
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
                <li class="active"><a href="./">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="./login">Login</a></li>
                <li><a href="./newaccount">Create an Account</a></li>
              </ul>

        </nav>
     
     
         <div class="container">
            
       <table id="parks-table" class="table table-responsive">
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
		<script
		src="https://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		crossorigin="anonymous"></script>
		<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<script src="scripts/script.js"></script>
    </body>
</html>