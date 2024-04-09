<?php
include ('../includes/connection.php');

if (!isset($_POST['department']) || !isset($_POST['course-to-add']))
    exit();


$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

try {
    $name = $_POST['course-to-add'];
    $did = $_POST['department'];        // this si the department id 

    $conn = connectToDB();
    $query = "INSERT INTO Course (name, departmentID) VALUES(?, ?);";

    $stmt = $conn -> prepare($query);

    $stmt -> bind_param("si", $name, $did);

    $stmt -> execute();

    $stmt->close();
    $conn->close();

    header("Location: $referrer");
} catch (Exception $e) {
    // Handle exception
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}