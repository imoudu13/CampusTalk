<?php

function connectToDB(){ return new mysqli("localhost", "77825776", "360@501Rex", "db_77825776"); }

// this code is for connecting to the db with xampp
// function connectToDB(){ return new mysqli("localhost", "root", "", "CampusTalk"); }

function close_db($conn) {
    $conn->close();
}
