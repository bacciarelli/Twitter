<?php
/*
CREATE TABLE Message (
  id int AUTO_INCREMENT,
  senderId int NOT NULL,
  reciverId int NOT NULL,
  messageText varchar(140) NOT NULL,
  creationDate DATETIME NOT NULL,
  readed int NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(senderId)  
  REFERENCES users(id),
  FOREIGN KEY(reciverId)  
  REFERENCES users(id)
    )
*/
class Message {
    
    private $id;
    private $senderId;
    private $reciverId;
    private $messageText;
    private $creationDate;
    private $readedStatus;

    function __construct() {
        $this->id = -1;
        $this->senderId = "";
        $this->reciverId = "";
        $this->messageText = "";
        $this->creationDate = "";
        $this->readedStatus = 0;
    }

    static public function loadMessageById(mysqli $conn, $id) {
        $sql = "SELECT * FROM Message WHERE id = $id";
        $result = $conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->senderId = $row['senderId'];
            $loadedMessage->reciverId = $row['reciverId'];
            $loadedMessage->messageText = $row['messageText'];
            $loadedMessage->creationDate = $row['creationDate'];
            $loadedMessage->readedStatus = $row['readedStatus'];

            return $loadedMessage;
        } else {
            return null;
            //else return null >????
        }
    }

    static public function loadAllSendedMessagesByUserId(mysqli $conn, $userId) {
        $sql = "SELECT * FROM Message WHERE senderId = $userId ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderId = $row['senderId'];
                $loadedMessage->reciverId = $row['reciverId'];
                $loadedMessage->messageText = $row['messageText'];
                $loadedMessage->creationDate = $row['creationDate'];
                $loadedMessage->readedStatus = $row['readedStatus'];
            
                $ret[] = $loadedMessage;
            }
        }

        return $ret;
    }
    
    static public function loadAllRecivedMessagesByUserId(mysqli $conn, $userId) {
        $sql = "SELECT * FROM Message WHERE reciverId = $userId ORDER BY creationDate DESC";
        $result = $conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Message();
                $loadedMessage->id = $row['id'];
                $loadedMessage->senderId = $row['senderId'];
                $loadedMessage->reciverId = $row['reciverId'];
                $loadedMessage->messageText = $row['messageText'];
                $loadedMessage->creationDate = $row['creationDate'];
                $loadedMessage->readedStatus = $row['readedStatus'];
            
                $ret[] = $loadedMessage;
            }
        }

        return $ret;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $statement = $conn->prepare("INSERT INTO Message (senderId, reciverId, messageText, creationDate, readedStatus)
                    VALUES (?, ?, ?, ?, ?)");

            if (!$statement) {
                return false;
            }
            $statement->bind_param('iissi', $this->senderId, $this->reciverId, $this->messageText, $this->creationDate, $this->readedStatus);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem. " . $statement->error;
            }
            return false;
        } else {
            $sql = "UPDATE Message SET readedStatus = $this->readedStatus WHERE id = $this->id";

            $result = $conn->query($sql);
            if ($result) {
                return TRUE;
            }
            print $result->error;
            print $result->errno;
            return FALSE;
        }
    }
    
    public function setSenderId() {
        $this->senderId = $_SESSION['userId'];
        return $this;
    }
    
    public function setReciverId($reciverId) {
        $this->reciverId = $reciverId;
        return $this;
    }

    public function setMessageText($messageText) {
        $this->messageText = $messageText;
        return $this;
    }

    public function setCreationDate() {
        $this->creationDate = date('Y-m-d H:i:s');
        return $this;
    }

    public function getId() {
        return $this->id;
    }
    
    public function setReadedStatus($readedStatus) {
        $this->readedStatus = $readedStatus;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReciverId() {
        return $this->reciverId;
    }

    function getMessageText() {
        return $this->messageText;
    }

    function getCreationDate() {
        return $this->creationDate;
    }

    function getReadedStatus() {
        return $this->readedStatus;
    }

    
}



?>