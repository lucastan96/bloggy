<?php
if (isset($_SESSION['login_user'])) {
    $id = $_SESSION['id'];

    $query = "SELECT first_name FROM member_details WHERE member_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id);
    $statement->execute();
    $result_array = $statement->fetch();
    $name = $result_array['first_name'];
    $statement->closeCursor();
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
		<li class='left'><a href="index"><i class="fa fa-home margin-true" aria-hidden="true"></i>Home</a></li>
		<li class='left'><a href="writers"><i class="fa fa-info-circle margin-true" aria-hidden="true"></i>Writers</a></li>
		<li class='left'><a href="about"><i class="fa fa-info-circle margin-true" aria-hidden="true"></i>About</a></li>
		<?php if (isset($_SESSION['login_user'])) { ?>
    		<li class='left'><a href="profile"><i class="fa fa-user margin-true" aria-hidden="true"></i><?php echo htmlspecialchars($name); ?></a></li>
		<?php } ?>
	    </ul>
	    <ul class="nav navbar-nav navbar-right">
		<?php if (isset($_SESSION['login_user'])) { ?>
    		<li class='right' id='signin-btn'><a href="logout"><i class="fa fa-sign-out margin-true" aria-hidden="true"></i>Sign Out</a></li>
		<?php } else { ?>
    		<li class='right' id='signin-btn'><a href="login"><i class="fa fa-sign-in margin-true" aria-hidden="true"></i>Sign In</a></li>
		<?php } ?>
	    </ul>
	    <form class="navbar-form navbar-right" role="search">
		<div class="input-group">
		    <input type="text" class="form-control no-border search" placeholder="Search Bloggy">
		    <span class="input-group-btn">
			<button class="btn btn-default no-border search" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
		    </span>
		</div>
	    </form>
	</div>
    </div>
</nav>