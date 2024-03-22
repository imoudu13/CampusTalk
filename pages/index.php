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
                    <a href="#">Major</a>
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
    <div class="right">
        <p class = "sidebar-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pellentesque id nibh tortor id aliquet. In vitae turpis massa sed elementum. Maecenas accumsan lacus vel facilisis volutpat est velit egestas. Aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc. Hac habitasse platea dictumst vestibulum rhoncus est. Sit amet risus nullam eget felis eget nunc lob</p>
    </div>
</main>

<?php require_once('../includes/footer.php'); ?>
