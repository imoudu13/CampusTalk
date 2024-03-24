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
        <!--        <a href="Post.html"> </a>-->
        <div class="main-content">
            <button id="toggle-columns">Toggle Columns</button>
            <div class="posts-container">

                <?php
                if (isset ($_GET['postId'])) {
                    $postId = $_GET['postId'];

                    $query = "SELECT * FROM Posts WHERE postID = ?;";
                    $commentsQuery = "SELECT * FROM Comments WHERE postID = ?;";

                    try {
                        $conn = connectToDB();

                        // throw an error in case it can't connect to the db
                        if ($conn->connect_error) {
                            throw new Exception("Connection failed: " . $conn->connect_error);
                        }

                        // Prepare and execute the query to fetch posts
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $postId);
                        $stmt->execute();

                        // Fetch posts
                        $postsResult = $stmt->get_result();
                        $posts = $postsResult->fetch_all(MYSQLI_ASSOC);

                        // Prepare and execute the query to fetch comments
                        $stmt = $conn->prepare($commentsQuery);
                        $stmt->bind_param("i", $postId);
                        $stmt->execute();

                        // Fetch comments
                        $commentsResult = $stmt->get_result();
                        $comments = $commentsResult->fetch_all(MYSQLI_ASSOC);

                        // Close the database connection
                        $conn->close();

                        // Combine posts and comments into a single array
                        $data = array(
                            'posts' => $posts,
                            'comments' => $comments
                        );
                        ?>
                        <!-- Load display the image -->
                        <div class="post-container" data-id="post.postID">
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
                                <input class="form-control comment-input" type="text" placeholder="Write a comment...">
                                <button class="btn btn-primary like-btn" data-post-id="post.postID">Like
                                    <span class="badge bg-secondary like-count"></span>
                                </button>
                            </div>
                        </div>
                        <?php
                        //load the comments
                        foreach ($comments as $comment) {
                            // Access individual comment data using $comment array
                            $commentId = $comment['commentID'];
                            $commentContent = $comment['content'];
                            $commentTitle = $comment['title'];
                            // Output the comment data or perform any desired operations
                            ?>
                            <div class="comment-container" data-id="post.postID">
                                <h2 class="comment-title">
                                    <?php echo $commentTitle; ?>
                                </h2>
                                <p class="comment-text">
                                    <?php echo $commentContent; ?>
                                </p>
                            </div>
                            <?php
                        }
                    } catch (Exception $e) {
                        // Show error message
                        echo "Error: " . $e->getMessage();
                    }
                }

                ?>
            </div>
        </div>
    </main>

    <?php require_once ('../includes/footer.php'); ?>