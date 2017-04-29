<div class="col-sm-4">
    <?php
    if (isset($_SESSION['user_status'])) {
	if ($_SESSION['user_status'] == 1 || $_SESSION['user_status'] == 2) {
	    ?>
	    <div class="writer-tools sidebar">
		<h3><i class="fa fa-wrench margin-true" aria-hidden="true"></i>Writer Tools</h3>
		<a href="addpost" role="button" class="btn btn-default no-border">Create Post</a>
		<a href="viewposts" role="button" class="btn btn-default no-border">View My Posts</a>
	    </div>
	    <?php
	}
    }
    ?>
    <div class="post-today sidebar">
	<h3><i class="fa fa-heart margin-true" aria-hidden="true"></i>Howdy!</h3>
	<p>We have <strong>2 new articles</strong> for you today. Enjoy!</p>
    </div>
    <div class="post-trending sidebar">
	<h3><i class="fa fa-fire margin-true" aria-hidden="true"></i>Trending</h3>
	<div class='post-trending-content'>
	    <img src="images/uploads/love_you_alvin.jpeg" alt="Love You Alvin Photo">
	    <div class='post-trending-title'><a href=''>Love You Alvin, Yeah I Really Do!</a></div>
	    <div class='post-trending-stats'>
		<i class="fa fa-eye" aria-hidden="true"></i>540
		<i class="fa fa-thumbs-up " aria-hidden="true"></i>103
		<i class="fa fa-comments" aria-hidden="true"></i>37
	    </div>
	</div>
	<div class='post-trending-content'>
	    <img src="images/uploads/hello_world.jpg" alt="Hello World Photo">
	    <div class='post-trending-title'><a href=''>Hello World, We Are Bloggy!</a></div>
	    <div class='post-trending-stats'>
		<i class="fa fa-eye" aria-hidden="true"></i>943
		<i class="fa fa-thumbs-up" aria-hidden="true"></i>482
		<i class="fa fa-comments" aria-hidden="true"></i>88
	    </div>
	</div>
	<div class='post-trending-content'>
	    <img src="images/uploads/hello_world.jpg" alt="Hello World Photo">
	    <div class='post-trending-title'><a href=''>Hello World, We Are Bloggy!</a></div>
	    <div class='post-trending-stats'>
		<i class="fa fa-eye" aria-hidden="true"></i>943
		<i class="fa fa-thumbs-up" aria-hidden="true"></i>482
		<i class="fa fa-comments" aria-hidden="true"></i>88
	    </div>
	</div>
	<div class='post-trending-content'>
	    <img src="images/uploads/hello_world.jpg" alt="Hello World Photo">
	    <div class='post-trending-title'><a href=''>Hello World, We Are Bloggy!</a></div>
	    <div class='post-trending-stats'>
		<i class="fa fa-eye" aria-hidden="true"></i>943
		<i class="fa fa-thumbs-up" aria-hidden="true"></i>482
		<i class="fa fa-comments" aria-hidden="true"></i>88
	    </div>
	</div>
	<div class='post-trending-content'>
	    <img src="images/uploads/hello_world.jpg" alt="Hello World Photo">
	    <div class='post-trending-title'><a href=''>Hello World, We Are Bloggy!</a></div>
	    <div class='post-trending-stats'>
		<i class="fa fa-eye" aria-hidden="true"></i>943
		<i class="fa fa-thumbs-up" aria-hidden="true"></i>482
		<i class="fa fa-comments" aria-hidden="true"></i>88
	    </div>
	</div>
    </div>
    <div class="social sidebar">
	<h3><i class="fa fa-plus-circle margin-true" aria-hidden="true"></i>Follow Us!</h3>
	<a href='https://facebook.com/' target='_blank' title='Facebook'><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
	<a href='https://twitter.com/' target='_blank' title='Twitter'><i class="fa fa-twitter" aria-hidden="true"></i></a>
	<a href='https://plus.google.com/' target='_blank' title='Google+'><i class="fa fa-google-plus-official" aria-hidden="true"></i></a>
	<a href='https://instagram.com/' target='_blank' title='Instagram'><i class="fa fa-instagram" aria-hidden="true"></i></a>
    </div>
</div>