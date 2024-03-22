<?php
require_once('../includes/connection.php');

function getDepartments() {
    $conn = connectToDB();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Department";
    $result = $conn->query($sql);
    $departments = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Construct the department object
            $department = [
                'departmentID' => $row['departmentID'], // Include the department name
                'departmentName' => $row['name'],
                'shorthandDepartmentName' => $row['shorthand'],
                'description' => $row['description']
            ];
            $departments[] = $department;
        }
    }

    close_db($conn);
    return $departments;
}

//echo the json encoded string
echo json_encode(getDepartments());
