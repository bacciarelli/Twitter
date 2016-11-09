<!DOCTYPE html>
<html lang="pl">
    <head>

        <meta charset="UTF-8">
        <title>Edycja danych</title>
    </head>
    <body>
        <a href="../index.php">Strona główna</a> |
        <a href="yourMessageSite.php">Twoje wiadomości</a> | 
        <a href="yourSite.php">Twoja strona</a> | 
        <a href="logout.php">Wyloguj się</a><br><br>
    </body>
    <h2>Formularz zmiany nazwy użytkownika</h2>
    <form action="" method="POST">
        Podaj nową nazwę użytkownika: <br>
        <input type="text" name ="name"/><br>
        <input type="submit" name="submit" value="Zmień nazwę"/>
    </form>
    
    <h2>Formularz zmiany hasła użytkownika</h2>
    <form action="" method="POST">
        Podaj swoje hasło: <br>
        <input type="password" name ="oldPassword"/><br>
        Podaj nowe hasło:<br>
        <input type="password" name ="newPassword"/><br><br>
        Powtórz nowe hasło:<br>
        <input type="password" name ="newPassword2"/><br><br>
        <input type="submit" name="submit" value="Zmień hasło"/>
    </form>

</html>
<?php

session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
    exit;
}
include_once 'confing.php';
include_once 'User.php';
$conn = getDbConnetion();
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $userId = $_SESSION['userId'];
    $user = User::loadUserById($conn, $userId);
    switch ($_POST['submit']) {
        case "Zmień nazwę":
            $user->setUsername($_POST['name']);
            $user->saveToDB($conn);
            print "Nazwa użytkownika została zmieniona na: " . $_POST['name'];
            $_SESSION ['username'] = $user->getUsername();
            break;
        
        case "Zmień hasło":
            $oldPassword = $_POST['oldPassword'];
            $userPass = $user->getHashedPassword();
            if (!password_verify($oldPassword, $userPass)) {
                exit("Podano złe stare hasło!<br>");
            }
            if($_POST['newPassword'] == $_POST['newPassword2']) {
                $user->setHashedPassword($_POST['newPassword2']);
                $user->saveToDB($conn);
                print "Hasło zostało zmienione.";
            } else {
                print "Powtórzono różne hasła!";
            }
            break;
        
        default:
            break;
    }
}

$conn->close();
$conn = null;
?>