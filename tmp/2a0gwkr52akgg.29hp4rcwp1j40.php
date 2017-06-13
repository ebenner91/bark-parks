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
				<?php if ($SESSION['loggedin'] == true): ?>
					
						<button class="btn" data-toggle="modal" data-target="#feature-modal">Add Feature(s)</button>
					<?php if ($featureSuccess): ?>
						<br><span class="text-success"><?= $featureSuccessText ?></span>
						<?php else: ?><br><span class="text-danger"><?= $featureErrorText ?></span>
					<?php endif; ?>
					
				<?php endif; ?>
				
                </div>
                <div class="col-sm-8 text-center">
                    <img src="<?= $images[0]['image_path'] ?>" class="featuredpics">
					<img src="<?= $images[1]['image_path'] ?>" class="featuredpics">
					<img src="<?= $images[2]['image_path'] ?>" class="featuredpics">
					<span class="col-sm-12 text-center">
					<button type="button" data-toggle="modal" data-target="#photo-modal" class="btn">
						View More Images
					</button>
					<?php if ($SESSION['loggedin'] == true): ?>
						
							<button class="btn" data-toggle="modal" data-target="#upload-modal">Upload a Photo</button>
						
					<?php endif; ?>
					</span>
					<?php if ($uploadErrors): ?>
						
							<span id="photo-errors" class="text-danger col-sm-12 text-center"><?= $photoErrorText ?></span>
						
					<?php endif; ?>
					<?php if ($imageSuccess): ?>
						
							<span id="photo-success" class="text-success col-sm-12 text-center"><?= $photoSuccessText ?></span>
						
					<?php endif; ?>
                </div>
				
            </div>
			<div class="row"><!-- Empty row to fix formatting problem --></div>
            <div class="row about-park">
                <div class="col-sm-6">
                    <h3>Description:</h3><br/>
                    <?= $park['description'].PHP_EOL ?>
                </div>
                <div class="col-sm-6">
                    <h3>Comments:</h3><br/>
					<div class="comment-block responsive">
						<?php foreach (($comments?:[]) as $comment): ?>
							<blockquote class="comment">
								<p><?= $comment['text'] ?></p>
								<footer><?= $comment['username'] ?> <span class="pull-right">Posted: <?= $comment['date_posted'] ?></span></footer>
							</blockquote>
						<?php endforeach; ?>
					</div>
                </div>
            </div>
        </div>
		
     
	<!-- Photo Modal -->
	<div id="photo-modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">More Photos</h4> 
		  </div>
		  <div class="modal-body">
			<p>
				<?php foreach (($images?:[]) as $image): ?>
					<img src="<?= $image['image_path'] ?>" class="featuredpics">
				<?php endforeach; ?>
			</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- /modal -->
	
	<!-- Upload Photo Modal -->
	<div id="upload-modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Upload a Photo</h4>
		  </div>
		  <div class="modal-body">
			<p>
				<form method="post" action="/328/bark-parks/viewpark/<?= $park['id'] ?>" enctype="multipart/form-data" name="info">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" readonly>
							<label class="input-group-btn">
								<span class="btn btn-default btn-gray">
									Upload a Photo <input type="file" name="image" accept="image/*" style="display: none;" required>
								</span>
							</label>
						</div>
					</div>
					<button type="submit" name="photo-submit" class="btn btn-default center-block btn-gray" value="create">Submit Photo</button>
				</form>
			</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		</div>
	</div>
	<!-- /modal -->
	
	<!-- Add Feature Modal -->
	<div id="feature-modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Feature()s</h4>
		  </div>
		  <div class="modal-body">
			<p>
				<form method="post" action="/328/bark-parks/viewpark/<?= $park['id'] ?>" enctype="multipart/form-data" name="info">
					<div class="form-group">
						<div class="input-group">
							<input class="form-control" type="text" name="features" id="features"
								   placeholder="Enter one or more features separated by commas" required>
							<span class="input-group-addon">Feature(s)</span>
						</div>
					</div>
					<button type="submit" name="feature-submit" class="btn btn-default center-block btn-gray" value="create">Submit Feature(s)</button>
				</form>
			</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		</div>
	</div>
	<!-- /modal -->	
            
	</div>
	<!--/.container-fluid -->
		<script
		src="https://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		crossorigin="anonymous"></script>
		<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
		integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
		crossorigin="anonymous"></script>
		<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<script src="../scripts/script.js"></script>
    </body>
</html>