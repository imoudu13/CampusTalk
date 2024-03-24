<?php require_once ('../includes/header.php'); ?>
<link href="../css/index.css" rel="stylesheet">
<script src="../js/postinfo.js"></script>
</head>

<body>
    <?php require_once ('../includes/nav.php'); ?>
    <main>
        <div class="left">
            <div class="sidebar-content">
                <div class="left-sidebar-topic">
                    <p class="sidebar-item left-item">
                        <a href="#">Home</a>
                    </p>
                    <p class="sidebar-item left-item">
                        <a href="#">Trending Now</a>
                    </p>
                </div>
                <div class="left-sidebar-topic sidebar-border-top">
                    <p class="topic-header">
                        <span style="color: white">Major</span>
                    </p>
                    <div id="department-container">

                    </div>
                </div>
                <div class="left-sidebar-topic sidebar-border-top">
                    <p class="sidebar-item left-item topic-header">
                        <a href="#">Help</a>
                    </p>
                    <p class="sidebar-item left-item ">
                        <a href="#">Report A Problem</a>
                    </p>
                    <p class="sidebar-item left-item ">
                        <a href="#">Contact Us</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="main-content">
            <button id="toggle-columns">Toggle Columns</button>
            <div class="posts-container">
                <?php
                if (isset ($_GET['postId'])) {
                    $postId = $_GET['postId'];

                    $query = "SELECT * FROM Posts WHERE postID = ?;";
                    $commentsQuery = "SELECT * FROM Comments JOIN Users ON Users.userID = Comments.UserID WHERE postID = ?;";

                    try {
                        $conn = connectToDB();

                        // throw an error in case it can't connect to the db
                        if ($conn->connect_error) {
                            throw new Exception("Connection failed: " . $conn->connect_error);
                        }

                        // prepare and execute the query to fetch posts
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $postId);
                        $stmt->execute();

                        // fetch posts
                        $postsResult = $stmt->get_result();
                        $posts = $postsResult->fetch_all(MYSQLI_ASSOC);

                        // prepare and execute the query to fetch comments
                        $stmt = $conn->prepare($commentsQuery);
                        $stmt->bind_param("i", $postId);
                        $stmt->execute();

                        // fetch comments
                        $commentsResult = $stmt->get_result();
                        $comments = $commentsResult->fetch_all(MYSQLI_ASSOC);

                        // close the database connection
                        $conn->close();
                        ?>
                        <!-- load hte post info -->
                        <div class="post-container" data-id="<?php echo $posts[0]['postID']?>">
                            <h2 class="post-title">
                                <?php echo htmlspecialchars($posts[0]['title']); ?>
                            </h2>

                            <p class="post-text">
                                <?php echo htmlspecialchars($posts[0]['content']); ?>
                            </p>
                            <p class="image-container post-img">
                                <img src="data:image/png;base64,<?php echo base64_encode($posts[0]['postImage']); ?>">
                            </p>
                            <div class="user-input-post">
                                <input class="form-control comment-input" id="commentBox" type="text" placeholder="Write a comment...">
                                <button class="btn btn-primary like-btn" id="commentButton">Comment</button>
                            </div>
                        </div>
                        <?php
                        $reversedComments = array_reverse($comments);
                        //load the comments
                        foreach ($reversedComments as $comment) {
                            // access individual comment data
                            $commentId = $comment['commentID'];
                            $commentContent = $comment['content'];
                            $username = $comment['username'];
                            // output the comment data
                            ?>
                            <div class="comment-container" data-id="post.postID">
                                <h5 class="username">
                                    <?php echo $username; ?>
                                </h5>
                                <p class="comment-text">
                                    <?php echo $commentContent; ?>
                                </p>
                            </div>
                            <?php
                        }
                    } catch (Exception $e) {
                        // show error message
                        echo "Error: " . $e->getMessage();
                    }
                }

                ?>
            </div>
        </div>
        <div class="right">
            <p class="sidebar-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua. Pellentesque id nibh tortor id aliquet. In vitae turpis
                massa sed elementum. Maecenas accumsan lacus vel facilisis volutpat est velit egestas. Aliquam malesuada
                bibendum arcu vitae elementum curabitur vitae nunc. Hac habitasse platea dictumst vestibulum rhoncus
                est. Sit amet risus nullam eget felis eget nunc lob</p>
        </div>
    </main>

    <?php require_once ('../includes/footer.php'); ?>