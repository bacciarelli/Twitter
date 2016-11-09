<?php
/*
CREATE TABLE Comment (
  id int AUTO_INCREMENT,
  tweetId int NOT NULL,
  userId int NOT NULL,
  commentText varchar(140) NOT NULL,
  creationDate DATETIME NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(tweetId)  
  REFERENCES Tweet(id)
    )
*/
class Comment {
    
    private $id;
    private $tweetId;
    private $userId;
    private $commentText;
    private $creationDate;

    function __construct() {
        $this->id = -1;
        $this->tweetId = "";
        $this->userId = "";
        $this->commentText = "";
        $this->creationDate = "";
    }

    static public function loadCommentById(mysqli $conn, $id) {
        $sql = "SELECT * FROM Comments WHERE id = $id";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['userId'];
            $loadedComment->tweetId = $row['tweetId'];
            $loadedComment->commentText = $row['commentText'];
            $loadedComment->creationDate = $row['creationDate'];

            return $loadedComment;
        } else {
            return null;
            //else return null >????
        }
    }

    static public function loadAllCommentsByTweetId(mysqli $conn, $tweetId) {
        $sql = "SELECT * FROM Comment WHERE tweetId = $tweetId ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['userId'];
                $loadedComment->tweetId = $row['tweetId'];
                $loadedComment->commentText = $row['commentText'];
                $loadedComment->creationDate = $row['creationDate'];

                $ret[] = $loadedComment;
            }
        }

        return $ret;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO Comment (userId, tweetId, commentText, creationDate)
                    VALUES (?, ?, ?, ?)");

            if (!$statement) {
                return false;
            }
            $statement->bind_param('iiss', $this->userId, $this->tweetId, $this->commentText, $this->creationDate);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem. " . $statement->error;
            }
            return false;
        } else {
            $sql = "UPDATE Comment SET commentText = '$this->commentText',
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
    
    public function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
        return $this;
    }

    public function setCommentText($commentText) {
        $this->commentText = $commentText;
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
    
    public function getTweetId() {
        return $this->tweetId;
    }

    public function getCommentText() {
        return $this->commentText;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }
    
    
}



?>
