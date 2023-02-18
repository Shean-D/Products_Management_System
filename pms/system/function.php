<?php

function dataClean($data = null) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function dbConn() {
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "pms";

    $conn = new mysqli($server, $user, $password, $db);

    if ($conn->connect_error) {
        die("Database connection error" . $conn->connect_error);
    } else {
        return $conn;
    }
}
