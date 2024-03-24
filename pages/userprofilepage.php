<head>
<?php require_once('../includes/header.php'); ?>
<!-- link to style sheet insert here later -->
<script src="../js/userprofilepage.js"></script> 
<head>

<body>
    <?php require_once('../includes/nav.php'); ?>
    <main>
        <h1>My Profile</h1>
        <div>
            <p><strong>Username: </strong><span id = "upp"></span></p>
            <br>
            <p><strong>Email: </strong><span id = "upp"></span></p>
            <br>
            <p><strong>First Name: </strong><span id = "upp"></span></p>
            <br>
            <p><strong>Last Name: </strong><span id = "upp"></span></p>
        </div>

        <h2>Change Password</h2>
        <form id = "passwordForm">
            <label for="newPassword">New Password: <label>
                <input type="password" id="newPassword" name = "newPassword">
                <input type = "submit" value = "Change Password">
        </form>

        
    </main>
</body>