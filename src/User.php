<?php

/*
 * CREATE TABLE users (
  id int AUTO_INCREMENT,
  username varchar(255),
  hashedPassword varchar(60) NOT NULL,
  email varchar(255) UNIQUE NOT NULL,
  PRIMARY KEY(id)
  )
 */

class User {

    private $id;
    private $username;
    private $hashedPassword;
    private $email;

    public function __construct() {
        $this->id = -1;
        $this->username = "";
        $this->hashedPassword = "";
        $this->email = "";
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getHashedPassword() {
        return $this->hashedPassword;
    }

    public function setHashedPassword($hashedPassword) {
        $newHashedPassword = password_hash($hashedPassword, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO users(username, hashedPassword, email)
                    VALUES (?, ?, ?)");

            if (!$statement) {
                return false;
            }
            $statement->bind_param('sss', $this->username, $this->hashedPassword, $this->email);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem. " . $statement->error;
            }
            return false;
        } else {
            $sql = "UPDATE users SET username = '$this->username',
                                    hashedPassword = '$this->hashedPassword',
                                    email = '$this->email'
                    WHERE id = $this->id";

            $result = $conn->query($sql);
            if ($result) {
                return TRUE;
            }
            return FALSE;
        }
    }

    static public function loadUserById(mysqli $conn, $id) {
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($sql);

        if ($result != FALSE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashedPassword = $row['hashedPassword'];
            $loadedUser->username = $row['username'];

            return $loadedUser;
        } else {
            return null;
            //else return null >????
        }
    }

    static public function loadAllUsers(mysqli $conn) {
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != FALSE && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->email = $row['email'];
                $loadedUser->hashedPassword = $row['hashedPassword'];
                $loadedUser->username = $row['username'];

                $ret[] = $loadedUser;
            }
        }

        return $ret;
    }

    static public function loadAllUsersByUsername(mysqli $conn, $username) {
        $sql = "SELECT * FROM users WHERE username LIKE '%$username%'";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->email = $row['email'];
                $loadedUser->hashedPassword = $row['hashedPassword'];
                $loadedUser->username = $row['username'];

                $ret[] = $loadedUser;
            }
        }

        return $ret;
    }
    
    static public function loadAllUsersByEmail(mysqli $conn, $email) {
        $sql = "SELECT * FROM users WHERE email LIKE '%$email%'";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->email = $row['email'];
                $loadedUser->hashedPassword = $row['hashedPassword'];
                $loadedUser->username = $row['username'];

                $ret[] = $loadedUser;
            }
        }

        return $ret;
    }
    
    public function delete(mysqli $conn) {
        if ($this->id == -1) {
           return true; 
        }
        
        $sql = "DELETE FROM users WHERE id = $this->id";
        $result = $conn->query($sql);
        if ($result) {
            $this->id = -1;
            return true;
        }
        return false;
        
    }

}

?>
