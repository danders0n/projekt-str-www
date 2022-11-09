<?php
    /* MySQLi Object-Oriented */
    $servername = "localhost";
    $username = "username";
    $password = "password";

    // Tworzenie polaczenie
    $conn = new mysqli($servername, $username, $password);

    // sprawdzanie polaczenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
?>