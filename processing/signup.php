<?php
include("../includes/connection.php");

//try inserting into the db. If the username is not unique there will be an error, 
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

try {
    // get some info from the post request
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Create connection
    $conn = connectToDB();

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare the insert statement with placeholders
    $sql = "INSERT INTO Users (username, firstname, lastname, email, userpassword) VALUES (?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);


    // Bind parameters
    $stmt->bind_param("sssss", $username, $firstname, $lastname, $email, $password);

    // Execute the statement
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
