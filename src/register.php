<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Rejestrowanie</title>
</head>
<body>
    <form action="" method="POST">
        Podaj swój e-mail: <br>
        <input type="text" name ="email"/><br>
        Podaj nazwę użytkownika: <br>
        <input type="text" name ="userName"/><br>
        Podaj swoje hasło:<br>
        <input type="password" name ="password"/><br><br>
        <input type="submit" value="Stwórz konto"/>
    </form>
    <p><a href="login.php">Zaloguj się</a></p>
</body>
</html>

<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once 'confing.php';
    require_once 'User.php';
    $conn = getDbConnetion();

    $email = $_POST['email'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $email = $conn->real_escape_string($email);
    $userName = $conn->real_escape_string($userName);
    $password = $conn->real_escape_string($password); 
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == true) {
            exit("Użytkownik o podanym e-mailu już istnieje<br>");
        } else {
            $newUser = new User();
            $newUser->setEmail($email);
            $newUser->setUsername($userName);
            $newUser->setHashedPassword($password);
            $newUser->saveToDB($conn);
            $_SESSION ['userId'] = $newUser->getId();
            $_SESSION ['username'] = $newUser->getUsername();
        }


        $result->free_result();
        $_SESSION['login'] = true;
        $conn->close();
        $conn = null;
        header('Location: ../index.php');
    }
}
?>
