<?php

class DBConnection
{
    private const host = 'detu.ddns.net';
    private const user = 'lipho';
    private const passw = 'Lipho@';
    private const db = 'lipho';
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->passw, $this->db);
        if ($this->conn->connect_error) {
            echo "Connection failed: " . $this->conn->connect_error;
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
