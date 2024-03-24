<?php
include("../includes/connection.php");
include("../processing/login.php");

//try inserting into the db. If the username is not unique there will be an error, 
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

try {
    // get some info from the post request
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    // create connection
    $conn = connectToDB();

    // check for connection error
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // prepare the insert statement with placeholders
    $sql = "INSERT INTO Users (username, firstname, lastname, email, userpassword) VALUES (?, ?, ?, ?, ?)";

    // create prepared statement
    $stmt = $conn->prepare($sql);


    // bind parameters
    $stmt->bind_param("sssss", $username, $firstname, $lastname, $email, $password);

    // execute
    if (!$stmt->execute()) {
        if ($conn->errno == 1062) { // MySQL error code for duplicate entry
            echo json_encode(array("error" => "username_not_unique", "redirect" => "index.php"));
        } else {
            throw new Exception("Error in executing statement: " . $stmt->error);
        }
    } else {
        // successful insertion, log user in then send success message
        $sql = "SELECT userID FROM Users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $userID;
        $stmt->bind_result($userID);
        $stmt->fetch();

        login($username, $userID, 0);
        echo json_encode(array("success" => true, "redirect" => "index.php"));
    }

    // close resources
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // return excveptions, good for debugging
    echo json_encode(array("error" => "An error occurred", "redirect" => "index.php"));
}
