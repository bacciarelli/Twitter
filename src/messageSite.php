<?php
session_start();
include_once 'confing.php';
include_once 'User.php';
include_once 'Message.php';

?>
<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Twitter</title>
</head>
<body>
    
<?php
if($_SERVER['REQUEST_METHOD'] != "GET") {
    header('Location: ../index.php');
} 
if ((isset($_SESSION['login'])) && ($_SESSION['login'] == true)) {
    echo '<a href="../index.php">Strona główna</a> | ';
    echo '<a href="yourSite.php">Twoja strona</a> | ';
    echo '<a href="yourMessageSite.php">Twoje wiadomości</a> | ';
    echo '<a href="logout.php">Wyloguj się</a><br><br>';
} else {
    echo header('Location: login.php');
}

$conn = getDbConnetion();
$message = Message::loadMessageById($conn, $_GET['messageId']);
$reciver = User::loadUserById($conn, $message->getReciverId());
$reciverId = $reciver->getId();
$reciverName = $reciver->getUsername();
$sender = User::loadUserById($conn, $message->getSenderId());
$senderId = $sender->getId();
$senderName = $sender->getUsername();
print "<a href= 'userSite.php?userId=$senderId' style='text-decoration: none; color: black'>"
        . "OD: <b>" . $senderName . "</b></a><br>";
print "<a href= 'userSite.php?userId=$reciverId' style='text-decoration: none; color: black'>"
        . "DO: <b>" . $reciverName . "</b></a><br>";
print "Data wysłania: " . $message->getCreationDate() . "<br><br>";
print "Treść wiadomości: &emsp;" . $message->getMessageText() . "<br><br>";

if($_SESSION['userId'] == $reciverId) {
    $message->setReadedStatus(1);
    $message->saveToDB($conn);
}

$conn->close();
$conn = null;
?>

</body>
</html>