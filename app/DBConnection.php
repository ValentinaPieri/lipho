<?php

const host = 'detu.ddns.net';
const user = 'lipho';
const passw = 'Lipho@';
const db = 'lipho';

class DBConnection
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(host, user, passw, db);
        if ($this->conn->connect_error) {
            echo "Connection failed: " . $this->conn->connect_error;
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
