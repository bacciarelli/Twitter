<?php
session_start();
include_once 'confing.php';
include_once 'User.php';
include_once 'Tweet.php';
include_once 'Comment.php';
include_once 'Message.php';

?>
<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Nowa wiadomość</title>
</head>
<body>
    
    <?php
    if($_SESSION['userId'] == $_GET['userId'] && $_SERVER['REQUEST_METHOD'] != "POST") {
        header('Location: ../index.php');
    }   
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
        Wyślij wiadomość do użytkownika: <br>
        <textarea name="messageText" cols="84" rows="5" placeholder="Wpisz wiadomość"></textarea>
        <input type="submit" value="Wyślij wiadomość"/>
    </form>
    <br>
</body>
</html>


<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = getDbConnetion();
    $newMessage = new Message();
    $newMessage->setSenderId($_SESSION['userId']);
    $newMessage->setReciverId($_GET['userId']);      
    $newMessage->setMessageText($_POST['messageText']);
    $newMessage->setCreationDate();
    $newMessage->saveToDB($conn);
    $conn->close();
    $conn = null;
    print "Wiadomość pomyślnie wysłana!";
}




?>