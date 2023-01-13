<?php

namespace app\models;

require_once 'app/query.php';

class User
{
    private string $username;

    private string $password;

    private string $name;

    private string $surname;

    private string $email;

    private string $phone;

    private string $birthdate;

    private bool $newUser;

    private $conn;

    private $profile_pic;

    public function __construct($username, $password, $name, $surname, $conn, $email, $phone, $birthdate, $profile_pic = "", $newUser = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->conn = $conn;
        $this->email = $email;
        $this->phone = $phone;
        $this->birthdate = $birthdate;
        $this->profile_pic = $profile_pic;
        $this->newUser = $newUser;

        if ($newUser) {
            $this->add();
        }
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getBirthDate()
    {
        return $this->birthdate;
    }

    public function add()
    {
        if ($this->email != "" && $this->phone != "" && $this->birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email_phone_birthdate']);
            $stmt->bind_param('sssssss', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->phone, $this->birthdate);
            $stmt->execute();
        } else if ($this->email != "" && $this->phone != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email_phone']);
            $stmt->bind_param('ssssss', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->phone);
            $stmt->execute();
        } else if ($this->email != "" && $this->birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email_birthdate']);
            $stmt->bind_param('ssssss', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->birthdate);
            $stmt->execute();
        } else if ($this->phone != "" && $this->birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_phone_birthdate']);
            $stmt->bind_param('ssssss', $this->username, $this->password, $this->name, $this->surname, $this->phone, $this->birthdate);
            $stmt->execute();
        } else if ($this->email != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_email']);
            $stmt->bind_param('sssss', $this->username, $this->password, $this->name, $this->surname, $this->email);
            $stmt->execute();
        } else if ($this->phone != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_phone']);
            $stmt->bind_param('sssss', $this->username, $this->password, $this->name, $this->surname, $this->phone);
            $stmt->execute();
        } else if ($this->birthdate != "") {
            $stmt = $this->conn->prepare(QUERIES['add_user_birthdate']);
            $stmt->bind_param('sssss', $this->username, $this->password, $this->name, $this->surname, $this->birthdate);
            $stmt->execute();
        } else {
            $stmt = $this->conn->prepare(QUERIES['add_user']);
            $stmt->bind_param('ssss', $this->username, $this->password, $this->name, $this->surname);
            $stmt->execute();
        }
    }

    public function delete()
    {
        $stmt = $this->conn->prepare(QUERIES['delete_user']);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
    }

    public function update()
    {
        $stmt = $this->conn->prepare(QUERIES['update_user']);
        $stmt->bind_param('ssssssi', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->phone, $this->birthdate);
        $stmt->execute();
    }
}