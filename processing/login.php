<?php

//include the db connection file
include ("../includes/connection.php");

// This is the function that logs a user in, it creates a session, give it a timeout and stores the users information in the session so we can use it in other places
function login($username, $userID, $isAdmin) {
    // Start or resume the session if it's not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Store user information in session variables
    $_SESSION['username'] = $username;
    $_SESSION['userID'] = $userID;
    $_SESSION['isAdmin'] = $isAdmin;

    // Session will timeout in an hour
    $timeout_seconds = 3600;
    $_SESSION['timeout'] = time() + $timeout_seconds;

    // Redirect the user to a logged-in page or any other desired location
    // header("Location: logged_in.php");
    // exit(); // Ensure that script execution stops after redirecting
}

// get the referrer info so that if it is set we can send the user back to the previous page upon completion of processing
$referrer = isset ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// start connecting to the db
try {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = connectToDB();

    // throw an error incase it can't connect to the db
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // this retrieves a tuple from the db using the entered username, if the user in the db it should return exactly one tuple
    // otherwise it returns nothing. we'll use that to know if the username exists in the db
    $query = "SELECT userID, userpassword, isAdmin FROM Users WHERE username = ?;";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);

    $stmt->execute();

    $stmt->store_result();

    // get the number of rows
    $numberOfRows = $stmt->num_rows;

    // if the number if rows is nothing that means the username doesn't exist in the db
    if ($numberOfRows == 0) {
        // so send a message back to js saying so
        echo json_encode(array("error" => "no result", "redirect" => "$referrer"));
    } else {
        $userID;
        $userpassword;
        $isAdmin;

        // otherwise the continue processing to see if the password is correct
        $stmt->bind_result($userID, $userpassword, $isAdmin);
        
        // Fetch the result
        $stmt->fetch();

        //hash the password here

        if($userpassword == $password){ // indicates a successful log in procedure
            // log the user in 
            login($username, $userID, $isAdmin);
            // send a success message
            echo json_encode(array("success" => "welcome", "redirect" => "$referrer"));
        }else{  // means the passwords do not match
            // send a message back about password being incorrect
            echo json_encode(array("error" => "incorrect password", "password" => "$userpassword", "redirect" => "$referrer"));
        }
    }


    $stmt->close();
    $conn->close();
} catch (Exception $e) {

}


