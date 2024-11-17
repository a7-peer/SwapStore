<?php
define('serverName', 'localhost');
define('username', 'root');
define('password', '');
define('database', 'SwapStore');

// Corrected function name
$conn = mysqli_connect(serverName, username, password, database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

