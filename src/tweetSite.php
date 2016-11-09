<?php
session_start();
include_once 'confing.php';
include_once 'User.php';
include_once 'Tweet.php';
include_once 'Comment.php';

?>
<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Tweetter</title>
</head>
<body>
    
    <?php
    if ((isset($_SESSION['login'])) && ($_SESSION['login'] == true)) {
        echo '<a href="../index.php">Strona główna</a> | ';
        echo '<a href="yourMessageSite.php">Twoje wiadomości</a> | ';
        echo '<a href="yourSite.php">Twoja strona</a> | ';
        echo '<a href="logout.php">Wyloguj się</a><br><br>';
    } else {
        echo header('Location: login.php');
    }
    ?>

    <form action="" method="POST">
        Skomentuj tweeta: <br>
        <textarea name="commentText" cols="84" rows="5" placeholder="Wpisz komentarz" maxlength="60"></textarea>
        <input type="submit" value="Wyślij komentarz"/>
    </form>
    <br>
</body>
</html>


<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = getDbConnetion();
    if(strlen($_POST['commentText']) > 60) {
        print "Komentarz może mieć maksymalnie 60 znaków!<br><br><br>";
        } else {
            $newComment = new Comment();
            $newComment->setCreationDate();
            $newComment->setUserId();
            $newComment->setTweetId($_GET['tweetId']);           
            $newComment->setCommentText($_POST['commentText']);
            $newComment->saveToDB($conn);
        }
    $conn->close();
    $conn = null;    
}

if($_SERVER['REQUEST_METHOD'] == "GET" | $_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = getDbConnetion();
    $tweet = Tweet::loadTweetById($conn, $_GET['tweetId']);
    $loadedUser = User::loadUserById($conn, $tweet->getUserId());
    $userId = $loadedUser->getId();
    print "<a href= 'userSite.php?userId=$userId' style='text-decoration: none; color: black'><b>" . $loadedUser->getUsername() . "</b></a> ";
    print $tweet->getCreationDate() . "<br>";
    print $tweet->getTweetText() . "<br><br>";
    print "Komentarze:<br><br>";

    $ret = Comment::loadAllCommentsByTweetId($conn, $_GET['tweetId']);
    foreach ($ret as $row) {        
        $loadedUser = User::loadUserById($conn, $row->getUserId());
        ?>
        <a href= 'userSite.php?userId=<?=$loadedUser->getId()?>' style='text-decoration: none; color: black'>
        &emsp;&emsp;<b><?=$loadedUser->getUsername()?></b></a>
        <?=$row->getCreationDate()?><br>
        &emsp;&emsp;<?=$row->getCommentText()?><br><hr>
        <?php
    }

    $conn->close();
    $conn = null;
} else {
    header('Location: ../index.php');
}


?>