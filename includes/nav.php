<?php
session_start();

// Include login.php
include("../processing/login.php");
?>
<!--Bootstrap nav bar-->
<head> 
    <script src="../js/register.js"></script>
    <script src="../js/login.js"></script>
</head>
<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top" style="background-color: #27374D !important;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CampusTalk</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Hot Topics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Random</a>
                </li>
            </ul>
            <div class="d-flex">
                <form class="d-flex me-2 flex-grow-1">
                    <input class="form-control me-2 flex-grow-1" type="search" placeholder="Search">
                </form>
                <?php if(isset($_SESSION['username'])) { ?>
                    <!-- Dropdown for logged-in users -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile Settings</a></li>
                            <li><a class="dropdown-item" href="#" id="logout">Sign Out</a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <!-- Login button for guests -->
                    <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal" id="loginbutton">Login</button>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<!-- Login Popup Modal -->
<!-- Data will get sent to login.php-->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Your login form goes here -->
                <!-- The action is to ensure that javascript catches the form on submit -->
                <form action="javascript:void(0);" id="loginform" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label" id="usernamelabel">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="pw" class="form-label" id="passwordlabel">Password</label>
                        <input type="password" class="form-control" id="pw" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <p class="text-center">Don't have an account? <button type="button" class="btn btn-link" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#signupModal">Sign up</button></p>
            </div>
        </div>
    </div>
</div>

<!-- Signup Popup Modal -->
<!-- Data will get sent to signup.php-->
<div class="modal fade" id="signupModal" tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" ></button>
            </div>
            <div class="modal-body">
                <!-- The action is to ensure that javascript catches the form on submit -->
                <form action="javascript:void(0);" method="POST" id="signupform">
                    <div class="mb-3">
                        <label for="username" class="form-label" id="errorMessage">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmpassword" class="form-label">Confirm Your Password</label>
                        <input type="password" class="form-control" name="confirmpassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </form>
            </div>
            <div class="modal-footer">
                <p class="text-center">Already have an account? <button type="button" class="btn btn-link" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Log In</button></p>
            </div>
        </div>
    </div>
</div>
