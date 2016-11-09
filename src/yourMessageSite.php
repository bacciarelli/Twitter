<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="UTF-8">
        <title>Twoje wiadomości</title>
    </head>
    <body>
        <a href="../index.php">Strona główna</a> |
        <a href="yourSite.php">Twoja strona</a> |  
        <a href="logout.php">Wyloguj się</a><br><br>
    </body>
</html>
<?php

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}

echo 'Witaj ' . $_SESSION['username'] . "!<br><br>";
$userId = $_SESSION['userId'];

include_once 'confing.php';
include_once 'User.php';
include_once 'Message.php';

$conn = getDbConnetion();
?>

<div style="width: 50%; float: left; clear: none">
<?php
$ret = Message::loadAllRecivedMessagesByUserId($conn, $userId);
print "<br>Twoje otrzymane wiadomości:<br><br>";
foreach ($ret as $row) {
    $messageId = $row->getId();
    $senderId = $row->getSenderId();
    $loadedUser = User::loadUserById($conn, $senderId);
    $userName = $loadedUser->getUsername();
    print "<a href= 'messageSite.php?messageId=$messageId;' style='text-decoration: none; color: black'>";
    print "Od: <b>" . $userName . "</b>";
    if($row->getReadedStatus() == 0) {
        print "<b> &emsp;Nieprzeczytane</b>";
    }
    if (strlen($row->getMessageText()) > 30) {
        print "<br>" . substr($row->getMessageText(), 0, 30) . "...<hr>";
    } else {
        print "<br>" . $row->getMessageText() . "<hr>";
    }
    print "</a>";
}
?>

</div>
<div style="width: 50%; float: right; clear: none">
<?php
$ret = Message::loadAllSendedMessagesByUserId($conn, $userId);
print "<br>Twoje wysłane wiadomości:<br><br>";
foreach ($ret as $row) {
    $messageId = $row->getId();
    $reciverId = $row->getReciverId();
    $loadedUser = User::loadUserById($conn, $reciverId);
    $userName = $loadedUser->getUsername();
    print "<a href= 'messageSite.php?messageId=$messageId;' style='text-decoration: none; color: black'>";
    print "Do: <b>" . $userName . "</b>";
    if($row->getReadedStatus() == 0) {
        print "<b> &emsp;Nieprzeczytane</b>";
    }
    if (strlen($row->getMessageText()) > 30) {
        print "<br>" . substr($row->getMessageText(), 0, 30) . "...<hr>";
    } else {
        print "<br>" . $row->getMessageText() . "<hr>";
    }
    print "</a>";
}
?>

</div>
<?php


$conn->close();
$conn = null;
?>