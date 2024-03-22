<?php require_once('../includes/header.php'); ?>
    </head>
    <body>
<?php require_once('../includes/nav.php'); ?>
// need to get connection from db

<?
$user = ['username' => 'example_user',
        'email' => 'user@example.com',
        'first_name' => 'hadi',
        'last_name' => 'razmi' ];

?>


    <form action="update_profile.php" method = "post">

	<label for="username">User Name: </label>
	<input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" readonly><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $user['email']; ?>"><br>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>"><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>"><br>

        <button type="submit">Update Information</button>
    </form>

    <form action="change_password.php" method="post">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Change Password</button>
    </form>




<?php require_once('../includes/footer.php'); ?>