<?php

const host = 'detu.ddns.net';
const user = 'lipho';
const passw = 'Lipho@';
const db = 'lipho';
const port = 3306;

$conn = new mysqli(host, user, passw, db, port);
if ($this->conn->connect_error) {
    echo "Connection failed: " . $this->conn->connect_error;
}
