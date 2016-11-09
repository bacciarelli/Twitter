<?php
session_start();
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
        echo '<a href="src/yourSite.php">Twoja strona</a> | ';
        echo '<a href="src/yourMessageSite.php">Twoje wiadomości</a> | ';
        echo '<a href="src/logout.php">Wyloguj się</a><br><br>';
    } else {
        echo header('Location: src/login.php');
    }
    ?>

    <form action="" method="POST">
        Stwórz tweeta: <br>
        <textarea name="tweetText" cols="84" rows="5" placeholder="Wpisz tweeta" maxlength="140"></textarea>
        <input type="submit" value="Wyślij tweeta"/>
    </form>
    <br>
</body>
</html>

<?php
include_once 'src/confing.php';
include_once 'src/User.php';
include_once 'src/Tweet.php';

$conn = getDbConnetion();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(strlen($_POST['tweetText']) > 140) {
        print "Tweet może mieć maksymalnie 140 znaków!<br><br><br>";
        } else {
            $newTweet = new Tweet();
            $newTweet->setCreationDate();
            $newTweet->setUserId();
            $newTweet->setTweetText($_POST['tweetText']);
            $newTweet->saveToDB($conn);
        }
}

$ret = Tweet::loadAllTweets($conn);
foreach ($ret as $row) {
    $loadedUser = User::loadUserById($conn, $row->getUserId());
    $tweetId = $row->getId();
    $userId = $loadedUser->getId();
    print "<a href= 'src/userSite.php?userId=$userId' style='text-decoration: none; color: black'>";
    print "<b>" . $loadedUser->getUsername() . "</b> ";
    print "</a>";
    print $row->getCreationDate() . "<br><br>";
    print "<a href= 'src/tweetSite.php?tweetId=$tweetId' style='text-decoration: none; color: black'>";
    print $row->getTweetText() . "<hr>";
    print "</a>";
}

$conn->close();
$conn = null;

?>