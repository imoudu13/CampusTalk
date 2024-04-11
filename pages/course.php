<?php require_once ('../includes/header.php'); ?>
<!DOCTYPE html>

<html>

<head>
    <link href="../css/course.css" rel="stylesheet">
    <script src="../js/course.js"></script>
</head>

<body>
    <?php
    require_once ('../includes/nav.php');
    require_once ('../includes/connection.php');
    ?>

    <?php

    if (!isset($_GET['cid']))
        die("Missing information.");

    $cid = $_GET['cid'];
    $userid = $_SESSION['userID'];

    try {
        $query = "SELECT commentID, content, cm.userID, cm.createdAt, username, profileimage FROM CourseMessage AS cm JOIN Users AS u ON cm.userID = u.userID WHERE cm.courseID = ?;";
        $conn = connectToDB();


        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $cid);
        $stmt->execute();

        $result = $stmt->get_result();
        $messages = $result->fetch_all(MYSQLI_ASSOC);

        $getName = "SELECT name FROM Course WHERE courseID = ?;";
        $stmt = $conn->prepare($getName);
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        $name = $result->fetch_all(MYSQLI_ASSOC);

        $stmt -> close();
        $conn -> close();
    } catch (Exception $e) {
        // Handle exception
        echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
    }
    ?>
    <main>
        <div class="left">
            <div class="sidebar-content">
                <div class="left-sidebar-topic">
                    <p class="sidebar-item left-item">
                        <a href="index.php">Home</a>
                    </p>
                    <p class="sidebar-item left-item">
                        <a href="../processing/leavecourse.php?cid=<?php echo $cid; ?>">Leave Course</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="main-content">
        <p id="course-name"> <?php echo $name[0]['name']; ?> </p>
            <div class="course-message-container">
                <?php
                foreach ($messages as $message) {
                    // access individual comment data
                    $mid = $message['commentID'];
                    $content = $message['content'];
                    $username = $message['username'];
                    // output the comment data
                    ?>
                    <div class="comment-container" data-id="<?php echo $mid; ?>">
                        <h5 class="username">
                            <?php if ($message['profileimage']) { ?>
                                <img src="data:image/png;base64,<?php echo base64_encode($message['profileimage']); ?>"
                                    alt="User Profile Pic">
                            <?php } ?>
                            <?php echo $username; ?>
                        </h5>
                        <p class="comment-text">
                            <?php echo $content; ?>
                        </p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div id="message-input-container">
            <textarea class="message-input" id="message-input-id" placeholder="Type your message"></textarea>
            <button id="send-message">Send</button>
        </div>
    </main>
</body>

</html>