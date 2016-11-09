<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="UTF-8">
        <title>Twoja strona</title>
    </head>
    <body>
        <a href="../index.php">Strona główna</a> |
        <a href="yourMessageSite.php">Twoje wiadomości</a> | 
        <a href="changeDataSite.php">Edycja danych</a> | 
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
include_once 'Tweet.php';
include_once 'Comment.php';

$conn = getDbConnetion();

$ret = Tweet::loadAllTweetsByUserId($conn, $userId);
print "<br>Twoje wszystkie tweety:<br><br>";
foreach ($ret as $row) {
    $tweetId = $row->getId();
    print "<a href= 'tweetSite.php?tweetId=$tweetId' style='text-decoration: none; color: black'>";
    print $row->getTweetText() . "<br>";
    print $row->getCreationDate() . " | ";
    $ret = Comment::loadAllCommentsByTweetId($conn, $tweetId);
    $count = 0;
    foreach ($ret as $row) {
        $count++;
    }
    print "Liczba komentarzy: $count<hr>";
    print "</a>";
}

$conn->close();
$conn = null;
?>