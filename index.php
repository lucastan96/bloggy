<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title>Home - Bloggy</title>
	<link href="styles/index.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class='container main-content'>
	    <div class="row">
		<div class="col-sm-8 posts">
		    <div class='post'>
			<div class='post-details'>
			    <div class='row'>
				<div class="col-sm-9">
				    <h2 class='post-title'><a href="post?id=2">Love You Alvin, Yeah I Really Do!</a></h2>
				    <img class="post-author-pic" src="images/profiles/member_1.jpg" alt="Lucas Tan Photo">
				    <div class="post-author-name"><a href='member?id=1'>Lucas Tan</a></div>
				    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on 2017-04-28 16:25</div>
				</div>
				<div class="col-sm-3">
				    <div class='post-stats'>
					<div class='post-views-count' title='540 Views'><i class="fa fa-eye margin-true" aria-hidden="true"></i>540</div>
					<div class='post-votes-count' title='103 Upvotes'><i class="fa fa-thumbs-up margin-true" aria-hidden="true"></i>103</div>
					<div class='post-comments-count' title='37 Comments'><i class="fa fa-comments margin-true" aria-hidden="true"></i>37</div>
				    </div>
				</div>
			    </div>
			</div>
			<img class='post-image' src="images/uploads/love_you_alvin.jpeg" alt="Love You Alvin Photo">
			<p class='post-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In accumsan tellus at dolor posuere, tincidunt eleifend dolor mattis. Curabitur placerat neque eu leo elementum, in imperdiet risus scelerisque. Cras nisi nunc, tempor nec euismod ac, facilisis tincidunt erat. In sed sem vel turpis placerat malesuada ac et neque. Aenean tincidunt enim arcu, ut rhoncus nisl ultrices eget. Curabitur rhoncus suscipit vehicula. Aenean a velit scelerisque justo dignissim iaculis. Etiam nec ipsum sed leo rutrum rhoncus. Duis aliquam, orci id egestas ultrices, lacus leo pellentesque massa, eu laoreet sapien urna in orci. Nunc sollicitudin arcu ac nisi pulvinar tincidunt.</p>
			<a href="post?id=2" role="button" class="btn btn-default button no-border post-button"><i class="fa fa-arrow-right margin-true" aria-hidden="true"></i>Read More</a>
		    </div>
		    <div class='post'>
			<div class='post-details'>
			    <div class='row'>
				<div class="col-sm-9">
				    <h2 class='post-title'><a href="post?id=1">Hello World, We Are Bloggy!</a></h2>
				    <img class="post-author-pic" src="images/profiles/member_1.jpg" alt="Lucas Tan Photo">
				    <div class="post-author-name"><a href='member?id=1'>Lucas Tan</a></div>
				    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on 2017-04-22 09:40</div>
				</div>
				<div class="col-sm-3">
				    <div class='post-stats'>
					<div class='post-views-count' title='2725 Views'><i class="fa fa-eye margin-true" aria-hidden="true"></i>2725</div>
					<div class='post-votes-count' title='482 Upvotes'><i class="fa fa-thumbs-up margin-true" aria-hidden="true"></i>482</div>
					<div class='post-comments-count' title='88 Comments'><i class="fa fa-comments margin-true" aria-hidden="true"></i>88</div>
				    </div>
				</div>
			    </div>
			</div>
			<p class='post-content'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In accumsan tellus at dolor posuere, tincidunt eleifend dolor mattis. Curabitur placerat neque eu leo elementum, in imperdiet risus scelerisque. Cras nisi nunc, tempor nec euismod ac, facilisis tincidunt erat. In sed sem vel turpis placerat malesuada ac et neque. Aenean tincidunt enim arcu, ut rhoncus nisl ultrices eget. Curabitur rhoncus suscipit vehicula. Aenean a velit scelerisque justo dignissim iaculis. Etiam nec ipsum sed leo rutrum rhoncus. Duis aliquam, orci id egestas ultrices, lacus leo pellentesque massa, eu laoreet sapien urna in orci. Nunc sollicitudin arcu ac nisi pulvinar tincidunt.</p>
			<a href="post?id=1" role="button" class="btn btn-default button no-border post-button"><i class="fa fa-arrow-right margin-true" aria-hidden="true"></i>Read More</a>
		    </div>
		</div>
		<div class="col-sm-4">
		    <div class="social sidebar">
			<h3>Follow Us!</h3>
			<a href='https://facebook.com/' target='_blank' title='Facebook'><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
			<a href='https://twitter.com/' target='_blank' title='Twitter'><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<a href='https://plus.google.com/' target='_blank' title='Google+'><i class="fa fa-google-plus-official" aria-hidden="true"></i></a>
			<a href='https://instagram.com/' target='_blank' title='Instagram'><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    </div>
		    <div class="post-today sidebar">
			<h3>Good Afternoon!</h3>
			<p>We have <strong>2 new articles</strong> for you today. Enjoy!</p>
		    </div>
		    <div class="post-trending sidebar">
			<h3>Trending</h3>

		    </div>
		</div>
	    </div>
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".left:nth-child(1)").addClass("active");
		$(".container").delay(200).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>
