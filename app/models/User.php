<?php

namespace app\models;

require_once 'app/query.php';

class User
{
    private string $username;

    private string $password;

    private string $name;

    private string $surname;

    private $email;

    private $phone;

    private $birth_date;

    private string $timestamp;

    private int $id;

    private $conn;

    private $profile_pic;

    public function __construct($username, $password, $name, $surname, $conn, $email, $phone, $birth_date, $profile_pic = "",  $timestamp = "", $id = 0)
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->conn = $conn;
        $this->email = $email;
        $this->phone = $phone;
        $this->birth_date = $birth_date;
        $this->profile_pic = $profile_pic;
        $this->timestamp = $timestamp;
        $this->id = $id;

        if($id==0){
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
        return $this->birth_date;
    }

    public function add()
    {
        if($this->email!="" && $this->phone!="" && $this->birth_date!=""){
            $stmt = $this->conn->prepare(QUERIES['add_user_email_phone_birthdate']);
            $stmt->bind_param('sssssss', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->phone, $this->birth_date);
        }else if($this->email!="" && $this->phone!=""){
            $stmt = $this->conn->prepare(QUERIES['add_user_email_phone']);
            $stmt->bind_param('ssssss', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->phone);
        }else if($this->email!="" && $this->birth_date!=""){
            $stmt = $this->conn->prepare(QUERIES['add_user_email_birthdate']);
            $stmt->bind_param('ssssss', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->birth_date);
        }else if($this->phone!="" && $this->birth_date!=""){
            $stmt = $this->conn->prepare(QUERIES['add_user_phone_birthdate']);
            $stmt->bind_param('ssssss', $this->username, $this->password, $this->name, $this->surname, $this->phone, $this->birth_date);
        }else if($this->email!=""){
            $stmt = $this->conn->prepare(QUERIES['add_user_email']);
            $stmt->bind_param('sssss', $this->username, $this->password, $this->name, $this->surname, $this->email);
        }else if($this->phone!=""){
            $stmt = $this->conn->prepare(QUERIES['add_user_phone']);
            $stmt->bind_param('sssss', $this->username, $this->password, $this->name, $this->surname, $this->phone);
        }else if($this->birth_date!=""){
            $stmt = $this->conn->prepare(QUERIES['add_user_birthdate']);
            $stmt->bind_param('sssss', $this->username, $this->password, $this->name, $this->surname, $this->birth_date);
        }else{
            $stmt = $this->conn->prepare(QUERIES['add_user']);
            $stmt->bind_param('ssss', $this->username, $this->password, $this->name, $this->surname);
        }
        $stmt->execute();
    }

    public function login()
    {
        $stmt = $this->conn->prepare(QUERIES['check_username']);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $result = $stmt->store_result();
        if ($result->num_rows > 0) {
            $stmt = $this->conn->prepare(QUERIES['check_password']);
            $stmt->bind_param('s', $this->password);
            $stmt->execute();
            $result = $stmt->store_result();
            if ($stmt->num_rows > 0) {
                return true;
            }
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
        $stmt->bind_param('ssssssi', $this->username, $this->password, $this->name, $this->surname, $this->email, $this->phone, $this->birth_date);
        $stmt->execute();
    }
}
