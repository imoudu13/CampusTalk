<?php
function connectToDB(){
    return new mysqli("localhost", "root", "", "CampusTalk");
}

function close_db($conn) {
    $conn->close();
}