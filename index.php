<?php
session_start();

require_once 'includes/connection.php';

$query = "SELECT * FROM post";
$statement = $db->prepare($query);
$statement->execute();
$result_array = $statement->fetchAll();
$statement->closeCursor();
?>
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
                <?php
                foreach ($result_array as $result):
                    $author_id = $result['member_id'];

                    $query2 = "SELECT * FROM member_details WHERE member_id=:member_id";
                    $statement2 = $db->prepare($query2);
                    $statement2->bindValue(":member_id", $author_id);
                    $statement2->execute();
                    $result_array2 = $statement2->fetchAll();
                    $statement2->closeCursor();

                    foreach ($result_array2 as $result2):
                        ?>

                        <div class="col-sm-8 posts">
                            <div class='post'>
                                <div class='post-details'>
                                    <div class='row'>
                                        <div class="col-sm-10">
                                            <h2 class='post-title'><a href="post?id=<?php echo htmlspecialchars($result['post_id']); ?>"><?php echo htmlspecialchars($result['post_title']); ?></a></h2>
                                            <div class='post-tags'>
                                                <p><strong>Tags:</strong>&nbsp;&nbsp;<span><a href=''>Love</a></span><span><a href=''>Alvin</a></span><span><a href=''>Really</a></span>&nbsp;&nbsp;+ 2 More</p>
                                            </div>
                                            <a href='member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title='<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?>'><img class="post-author-pic" src="images/profiles/<?php echo htmlspecialchars($result2['profile_pic']); ?>" alt="<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?> Photo"></a>
                                            <div class="post-author-name"><a href='member?id=<?php echo htmlspecialchars($result['member_id']); ?>'><?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?></a></div>
                                            <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class='post-stats'>
                                                <div class='post-views-count' title='540 Views'><i class="fa fa-eye margin-true" aria-hidden="true"></i>540</div>
                                                <div class='post-votes-count' title='103 Upvotes'><i class="fa fa-thumbs-up margin-true" aria-hidden="true"></i>103</div>
                                                <div class='post-comments-count' title='37 Comments'><i class="fa fa-comments margin-true" aria-hidden="true"></i>37</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img class='post-image' src="images/uploads/<?php echo htmlspecialchars($result['post_image']); ?>" alt="Love You Alvin Photo">
                                <p class='post-content'><?php echo htmlspecialchars($result['post_content']); ?></p>
                                <a href="post?id=2" role="button" class="btn btn-default button no-border post-button"><i class="fa fa-arrow-right margin-true" aria-hidden="true"></i>Read More</a>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endforeach;
                ?>
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
            $(".post").delay(100).animate({opacity: 1}, 300);
            $(".sidebar").delay(200).animate({opacity: 1}, 300);
        });
    </script>
</body>
</html>
