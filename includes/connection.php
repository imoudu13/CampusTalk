<?php
//function connectToDB(){ return new mysqli("localhost", "35669746", "35669746", "db_35669746"); }

// this code is for connecting to the db with xampp
function connectToDB(){ return new mysqli("localhost", "root", "", "CampusTalk"); }

function close_db($conn) {
    $conn->close();
}
