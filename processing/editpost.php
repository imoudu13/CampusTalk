<?php

include ("../includes/connection.php");

if ($_SERVER['REQUEST_METHOD'] == "GET")
    die ("having trouble getting data");

if (!$_POST['hiddenpostid'] || !$_POST['title'])
    die ("incomplete data");


try {
    $referrer = isset ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

    $conn = connectToDB();

    // throw an error incase it can't connect to the db
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // this is the statement for updating the db
    $update_statement = "UPDATE Posts SET title = ?, content = ? WHERE postID = ?;";

    // get the title, content and post id from the post request
    $title = $_POST['title'];
    $content = $_POST['content'];
    $pid = $_POST['hiddenpostid'];

    $stmt = $conn->prepare($update_statement);
    $stmt->bind_param('ssi', $title, $content, $pid);

    $stmt->execute();

    $stmt->close();
    $conn->close();

    echo json_encode(array("success" => "it worked", "redirect" => "$referrer"));
} catch (Exception $e) {
    // Handle exception
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}