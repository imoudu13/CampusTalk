<head>
<?php require_once('../includes/header.php'); ?>
<<<<<<< HEAD
<script src="../js/userprofilepage.js"></script>
<link rel = "stylesheet" href= "../css/userprofilepage.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <!-- include the nav.php -->
    <?php require_once('../includes/nav.php');?>

    <main>
<div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src=" " alt="Gotta put a profile picture here"/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <p><strong>User name goes here<span id="username"></span></p>
                                    </h5>
                                    <h6>
                                        <p><strong>User since <span id="createdAt"></span></p>
                                    </h6>
                                    <p class="proile-rating">Your Profile Information </span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>Your Communities</p>
                            <a href="">Data Science</a><br/>
                            <a href="">Management</a><br/>
                            <a href="">UBCO Heat</a>
                            <p>Posts</p>
                            <a href="">Thoughts on COSC360?</a><br/>
                            <a href="">Freelance Tutor in Kelowna</a><br/>
                            <a href="">How to get good sleep as a student?</a><br/>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Username </label>
                                            </div>
                                            <div class="col-md-6">
                                                <!--DISPLAY USERNAME HERE -->
                                            <p><strong><span id="username"></span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>First Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <!--DISPLAY FIRST NAME HERE -->
                                            <p><strong><span id="firstName"></span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                 <!--DISPLAY FIRST NAME HERE -->
                                            <p><strong><span id="email"></span></p>
                                            </div>
                                        </div>
                                        
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>

</main>
=======
<!-- link to style sheet insert here later -->
<script src="../js/userprofilepage.js"></script> 
<head>

<body>
    <?php require_once('../includes/nav.php'); ?>
    <main>
        <h1>My Profile</h1>
        <div>
            <p><strong>Username: </strong><span id = "username"></span></p>
            <br>
            <p><strong>Email: </strong><span id = "email"></span></p>
            <br>
            <p><strong>First Name: </strong><span id = "firstName"></span></p>
            <br>
            <p><strong>Last Name: </strong><span id = "lastName"></span></p>
        </div>

        <h2>Change Password</h2>
        <form id = "passwordForm">
            <label for="newPassword">New Password: <label>
                <input type="password" id="newPassword" name = "newPassword">
                <input type = "submit" value = "Change Password">
        </form>


    </main>
>>>>>>> 74e632925415a7571e0555e674a17f71362e00b8
</body>