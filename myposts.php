<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: login");
    exit();
} else {
    if ($_SESSION['user_status'] != 1 && $_SESSION['user_status'] != 2) {
        header("Location: index");
        exit();
    } else {
        if (isset($_SESSION['postDeleted'])) {
            $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your post has been deleted.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
            $_SESSION['postDeleted'] = null;
        }

        require_once 'includes/connection.php';
        require_once 'includes/checkinactivity.php';

        $query1 = "SELECT * FROM post WHERE member_id = :member_id ORDER BY post_id DESC";
        $statement1 = $db->prepare($query1);
        $statement1->bindValue("member_id", $_SESSION["id"]);
        $statement1->execute();
        $result_array1 = $statement1->fetchAll();
        $statement1->closeCursor();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>My Posts - Bloggy</title>
        <link href="styles/myposts.css" rel="stylesheet">
    </head>
    <body>
        <?php include("Includes/nav.php"); ?>

        <div class='container main-content'>
            <div class="row">
                <div class="col-sm-8 posts">
                    <div class='post'>
                        <h2><i class="fa fa-pencil-square-o" aria-hidden="true"></i>My Posts</h2>
                    </div>
                    <?php
                    if (isset($message)) {
                        echo "<div id='message' title='Click to Dismiss'>" . $message . "</div>";
                    }
                    ?>
                    <?php foreach ($result_array1 as $result): ?>
                        <div class="post">
                            <h2>Post #<?php echo htmlspecialchars($result["post_id"]) . " - " . htmlspecialchars($result["post_title"]); ?></h2>
                            <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
                            <?php if ($result['post_image'] != "") { ?>
                                <img class='post-image' src="images/uploads/<?php echo htmlspecialchars($result['post_image']); ?>" alt="Post Photo">
                            <?php } ?>
                            <div class="post-actions">
                                <a href="post?id=<?php echo htmlspecialchars($result["post_id"]); ?>" role="button" class="btn btn-default no-border"><i class="fa fa-eye margin-true" aria-hidden="true"></i>View</a>
                                <a href="editpost?id=<?php echo htmlspecialchars($result["post_id"]); ?>" role="button" class="btn btn-default no-border"><i class="fa fa-pencil margin-true" aria-hidden="true"></i>Edit</a>
                                <form action="includes/deletepostprocess" method="post">
                                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($result["post_id"]); ?>"/>
                                    <button type="submit" class="btn btn-default no-border" onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone!')"><i class="fa fa-trash margin-true" aria-hidden="true"></i>Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php include("includes/sidebar.php"); ?>
            </div>
        </div>

        <?php include("includes/footer.php"); ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".left:nth-child(2)").addClass("active");
                $(".post").delay(100).animate({opacity: 1}, 300);
                $(".sidebar").delay(200).animate({opacity: 1}, 300);
                $("#message").click(function () {
                    $("#message").fadeOut();
                });
            });
        </script>
    </body>
</html>
