<?php
$hostname = "localhost";
$username = "local";
$password = "password";
$database = "GuildTalk";

function connectToDB($host, $username, $password, $db){
    return new mysqli($host, $username, $password, $db);
}

function close_db($conn) {
    $conn->close();
}