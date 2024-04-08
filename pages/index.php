<?php require_once ('../includes/header.php'); ?>
<link href="../css/index.css" rel="stylesheet">
<script src="../js/index.js"></script>
</head>

<body>
    <?php require_once ('../includes/nav.php'); ?>
    <main>
        <div class="left">
            <div class="sidebar-content">
                <div class="left-sidebar-topic">
                    <p class="sidebar-item left-item">
                        <a href="index.php">Home</a>
                    </p>
                </div>
                <div class="left-sidebar-topic sidebar-border-top">
                    <p class="topic-header">
                        <span>Department</span>
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
                <!--Filled by get_posts and index.js -->
            </div>
        </div>
        <!-- display the admin bar if admin    -->
        <?php if (isset($_SESSION['isAdmin']) && ($_SESSION['isAdmin'] == 1)) { ?>
            <div class="right">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Admin Controls</h5>
                    </div>
                    <div class="card-body">
                        <form action="javascript:void(0);" method="POST" id="admin-search-form" class="d-flex flex-column">
                            <div class="mb-3">
                                <label for="userInformationAdminSelect" class="form-label" id="departmentLabel">Search For
                                    User By</label>
                                <select class="form-select" id="userInformationAdminSelect" name="userInformationAdmin">
                                    <option value="0">Username</option>
                                    <option value="1">Email</option>
                                    <option value="2">Post</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" id="admin-search-bar" type="search" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($_SESSION['userID']) && ($_SESSION['isAdmin'] === 0)) { ?>

            <!-- Join course bar -->
            <div class="right">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Join a Course</h5>
                    </div>
                    <div class="card-body">
                        <form action="javascript:void(0);" method="POST" id="join-course-form" class="d-flex flex-column">
                            <div class="mb-3">
                                <label for="course-search-bar" class="form-label">Search a Course</label>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" id="course-search-bar" type="search" placeholder="Search"
                                    name="courseName">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <?php
                    $userid = $_SESSION['userID'];
                    try {
                        $query = "SELECT uc.courseID, name FROM UserCourse AS uc JOIN Course AS c ON uc.courseID = c.courseID WHERE uc.userID = ?;";

                        $conn = connectToDB();
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $userid);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $coursesResult = $result->fetch_all(MYSQLI_ASSOC);
                    } catch (Exception $e) {
                        // Handle exception
                        echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
                    }
                    ?>

                    <?php if (count($coursesResult) > 0) { ?>
                        <div class="card-header">
                            <h5 class="card-title mb-0">Your Courses</h5>
                        </div>
                        <!-- Display the courses this user is a part of -->
                        <div class="card-body">

                            <?php
                            foreach ($coursesResult as $course) {
                                // access individual comment data
                                $cid = $course['courseID'];
                                $cname = $course['name'];
                                // output the comment data
                                ?>
                                <div class="course-container">
                                    <a href="../pages/course.php?cid=<?php echo $cid; ?>" class="course-link"> <?php echo $cname; ?> </a>
                                </div>
                                <?php
                            } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </main>

    <!-- Modal to display users when admin searches for them -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Search Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="userModalBody">
                    <!-- Users will be populated here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to display courses when user searches for them -->
    <div class="modal fade" id="course-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="course-modal-label">Search Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="course-modal-body">
                    <!-- Courses will be populated here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once ('../includes/footer.php'); ?>