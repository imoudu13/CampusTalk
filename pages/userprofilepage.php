<?php require_once('../includes/header.php'); ?>
// if you want to add custom styles or js link it here
// custom styles have to override bootstrap styles... can be difficult

    </head>
    <body>

<?php require_once('../includes/nav.php'); ?>

<?php
include('../includes/connection.php');

$conn = connectToDB();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
//Check if user is logged in, otherwise send them to login/register page

<?php
if(!isset($_SESSION['username']) && !isset($_SESSION['userpassword'])){
    header("Location: signup.php"); //redirect to sign up page 
   exit(); }

//Get user details from DB

$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username' ";
$result = mysqli_query($conn, $query);
if(!$result){
    die("Database query failed. No username found in database.");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['passwordchange'])){
    $new_pass = $_POST['new_pass'];
    $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
    $update_password_query = "UPDATE users SET userpassword = '$hashed_pass' WHERE username = '$username' ";
    $update_pass = mysqli_query($conn, $update_query);
    if(!$update_result){
        die("Password fail to be change!");
    }

    echo "You have updated your password!";
}

?>

<!-- html code for displaying user information --> 
<html>
<body>
<h2> User Profile </h2>
<p>Username: <?php echo $user['username']; ?></p>
<p>Email: <?php echo $user['email']; ?></p>
<p>First Name: <?php echo $user['firstname']; ?></p>
<p>Last Name: <?php echo $user['lastname']; ?></p>

<h3> Change Password </h3>
<form method = "post" action "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <label for="new_pass">Enter New Password: </label>
    <input type = "password" name = "new_pass" > <br>
    <input type = "submit" name = "passwordchange" value = "";
</form>
</body>
</html>



<?php require_once('../includes/footer.php'); ?>