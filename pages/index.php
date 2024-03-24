<?php require_once('../includes/header.php'); ?>
<link href="../css/index.css" rel="stylesheet">
<script src="../js/index.js"></script>
</head>
<body>
<?php require_once('../includes/nav.php'); ?>
<main>
    <div class="left">
        <div class = "sidebar-content">
            <div class = "left-sidebar-topic">
                <p class = "sidebar-item left-item">
                    <a href="#">Home</a>
                </p>
                <p class = "sidebar-item left-item">
                    <a href="#">Trending Now</a>
                </p>
            </div>
            <div class = "left-sidebar-topic sidebar-border-top">
                <p class = "topic-header">
                    <span style="color: white">Major</span>
                </p>
                <div id = "department-container">

                </div>
            </div>
            <div class = "left-sidebar-topic sidebar-border-top">
                <p class = "sidebar-item left-item topic-header">
                    <a href="#">Help</a>
                </p>
                <p class = "sidebar-item left-item ">
                    <a href="#">Report A Problem</a>
                </p>
                <p class = "sidebar-item left-item ">
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
            <p class = "sidebar-content admin-header">Admin Controls</p>
        </div>
    <?php } ?>
</main>

<?php require_once('../includes/footer.php'); ?>
