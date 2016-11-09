<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="UTF-8">
        <title>Twitter</title>
    </head>
    <body>
        <a href="../index.php">Strona główna</a> |
        <a href="yourSite.php">Twoja strona</a> | 
        <a href="yourMessageSite.php">Twoje wiadomości</a> | 
        <a href="logout.php">Wyloguj się</a><br><br>

    </body>
</html>


<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}


include_once 'confing.php';
include_once 'User.php';
include_once 'Tweet.php';
include_once 'Comment.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $conn = getDbConnetion();
    
    $ret = Tweet::loadAllTweetsByUserId($conn, $_GET['userId']);
    $loadedUser = User::loadUserById($conn, $_GET['userId']);
    $userName = $loadedUser->getUsername();
    $userId = $loadedUser->getId();
    print "<br>Wszystkie tweety użytkownika: <b>$userName</b>";
    
    if($_SESSION['userId'] != $_GET['userId']){
        print "&emsp;&emsp;<a href= 'createMessageSite.php?userId=$userId' "
            . "style='text-decoration: none; color: black'><button type='button'>"
            . "Wyślij wiadomość do <b>$userName</b></button></a>";
    }
    print "<br><br>";
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
} else {
    header('Location: ../index.php');
}

?>