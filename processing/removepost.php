<?php

include ("../includes/connection.php");

if ($_SERVER['REQUEST_METHOD'] == "GET")
    die ("having trouble getting data");

if (!isset($_POST['postId']))
    die ("incomplete data");

try {
    $conn = connectToDB();

    $pid = $_POST['postId'];

    $remove_statement = "DELETE FROM Posts WHERE postID = ?;";

    $stmt = $conn->prepare($remove_statement);
    $stmt->bind_param("i", $pid);

    $stmt->execute();

    echo json_encode(array("success" => "it worked"));
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}