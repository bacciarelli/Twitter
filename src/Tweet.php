<?php

/*
 * CREATE TABLE Tweet (
  id int AUTO_INCREMENT,
  userId int NOT NULL,
  tweetText varchar(140) NOT NULL,
  creationDate DATETIME NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(userId)
  REFERENCES users(id)
  //ON DELETE CASCADE
  )
 */

class Tweet {

    private $id;
    private $userId;
    private $tweetText;
    private $creationDate;

    function __construct() {
        $this->id = -1;
        $this->userId = "";
        $this->tweetText = "";
        $this->creationDate = "";
    }

    static public function loadTweetById(mysqli $conn, $id) {
        $sql = "SELECT * FROM Tweet WHERE id = $id";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->tweetText = $row['tweetText'];
            $loadedTweet->creationDate = $row['creationDate'];

            return $loadedTweet;
        } else {
            return null;
            //else return null >????
        }
    }

    static public function loadAllTweetsByUserId(mysqli $conn, $userId) {
        $sql = "SELECT * FROM Tweet WHERE userId = $userId ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweetText = $row['tweetText'];
                $loadedTweet->creationDate = $row['creationDate'];

                $ret[] = $loadedTweet;
            }
        }

        return $ret;
    }
    
    static public function loadAllTweets(mysqli $conn) {
        $sql = "SELECT * FROM Tweet ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != FALSE && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->tweetText = $row['tweetText'];
                $loadedTweet->creationDate = $row['creationDate'];

                $ret[] = $loadedTweet;
            }
        }

        return $ret;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO Tweet(userId, tweetText, creationDate)
                    VALUES (?, ?, ?)");

            if (!$statement) {
                return false;
            }
            $statement->bind_param('iss', $this->userId, $this->tweetText, $this->creationDate);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem. " . $statement->error;
            }
            return false;
        } else {
            $sql = "UPDATE Tweet SET tweetText = '$this->tweetText',
                                    creationDate = '$this->creationDate',
                    WHERE id = $this->id";

            $result = $conn->query($sql);
            if ($result) {
                return TRUE;
            }
            return FALSE;
        }
    }
    
    public function setUserId() {
        $this->userId = $_SESSION['userId'];
        return $this;
    }

    public function setTweetText($tweetText) {
        $this->tweetText = $tweetText;
        return $this;
    }

    public function setCreationDate() {
        $this->creationDate = date('Y-m-d H:i:s');
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTweetText() {
        return $this->tweetText;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

}

?>