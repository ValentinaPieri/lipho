<?php

class DBConnection
{
    private $host = 'detu.ddns.net';
    private $user = 'lipho';
    private $passw = 'Lipho@';
    private $db = 'lipho';
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
?>