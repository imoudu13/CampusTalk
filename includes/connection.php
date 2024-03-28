<?php
function connectToDB(){
    return new mysqli("localhost", "77825776", "360@501Rex", "db_77825776");
}

function close_db($conn) {
    $conn->close();
}
