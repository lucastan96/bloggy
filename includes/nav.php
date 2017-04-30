<?php
if (isset($_SESSION['login_user'])) {
    $id = $_SESSION['id'];

    $query = "SELECT first_name, profile_pic FROM member_details WHERE member_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->execute();
    $nav_array = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($nav_array as $nav_data):
	$nav_name = $nav_data["first_name"];
	$nav_profile_pic = $nav_data["profile_pic"];
    endforeach;
}
?>
<nav class="navbar">
    <div class="container">
	<div class="navbar-header">
	    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	    </button>
	    <h1><a href="index">Bloggy</a></h1>
	</div>
	<div id="navbar" class="collapse navbar-collapse">
	    <ul class="nav navbar-nav">
		<li class='left'><a href="index"><i class="fa fa-home fa-fw margin-true" aria-hidden="true"></i>Home</a></li>
		<li class='left'><a href="writers"><i class="fa fa-pencil fa-fw margin-true" aria-hidden="true"></i>Writers</a></li>
		<li class='left'><a href="about"><i class="fa fa-info-circle fa-fw margin-true" aria-hidden="true"></i>About</a></li>
		<?php if (isset($_SESSION['login_user'])) { ?>
    		<li class='left'><a href="profile"><img class="navbar-pic" src="images/profiles/<?php echo htmlspecialchars($nav_profile_pic); ?>" alt="Profile Picture"><?php echo htmlspecialchars($nav_name); ?></a></li>
		<?php } ?>
	    </ul>
	    <ul class="nav navbar-nav navbar-right">
		<?php if (isset($_SESSION['login_user'])) { ?>
    		<li class='right' id='signin-btn'><a href="logout"><i class="fa fa-sign-out fa-fw margin-true" aria-hidden="true"></i>Sign Out</a></li>
		<?php } else { ?>
    		<li class='right' id='signin-btn'><a href="login"><i class="fa fa-sign-in fa-fw margin-true" aria-hidden="true"></i>Sign In</a></li>
		<?php } ?>
	    </ul>
	    <form class="navbar-form navbar-right" role="search" method="get" action="search">
		<div class="input-group">
		    <input type="text" class="form-control no-border search" placeholder="Search Bloggy" name="query" required>
		    <span class="input-group-btn">
			<button class="btn btn-default no-border search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
		    </span>
		</div>
	    </form>
	</div>
    </div>
</nav>