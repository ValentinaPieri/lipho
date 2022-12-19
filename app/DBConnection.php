<?php

const host = 'detu.ddns.net';
const user = 'lipho';
const passw = 'Lipho@';
const db = 'lipho';
const port = 3306;

$conn = new mysqli(host, user, passw, db, port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>