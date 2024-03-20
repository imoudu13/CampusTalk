<?php
function connectToDB(){
    return new mysqli("localhost", "root", "", "GuildTalk");
}

function close_db($conn) {
    $conn->close();
}