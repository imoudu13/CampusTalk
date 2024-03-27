<?php
require_once("../includes/connection.php");

//try inserting into the db. If the username is not unique there will be an error, 
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

try {
    // get some info from the post request
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedpw = md5($password);

    // Handle image upload separately
    if (isset ($_FILES['profileimage']) && $_FILES['profileimage']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['profileimage']['name'];
        // Process and move the uploaded file to desired location
        $image = file_get_contents($_FILES['profileimage']['tmp_name']);
    } else {
        // Handle case where image is not uploaded
        $image = null;
    }

    // create connection
    $conn = connectToDB();

    // check for connection error
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // prepare the insert statement with placeholders
    $sql = "INSERT INTO Users (username, firstname, lastname, email, userpassword, profileimage) VALUES (?, ?, ?, ?, ?, ?)";

    // create prepared statement
    $stmt = $conn->prepare($sql);


    // bind parameters
    $stmt->bind_param("sssssb", $username, $firstname, $lastname, $email, $hashedpw, $image);

    // execute
    if (!$stmt->execute()) {
        if ($conn->errno == 1062) { // MySQL error code for duplicate entry
            echo json_encode(array("error" => "username_not_unique", "redirect" => "index.php"));
        } else {
            throw new Exception("Error in executing statement: " . $stmt->error);
        }
    } else {
        // Successful insertion, send success message
        echo json_encode(array("success" => true, "redirect" => "index.php"));
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle any exceptions here
    echo json_encode(array("error" => "An error occurred", "redirect" => "index.php"));
}