<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
    <form action="" method="POST">
        Podaj swój e-mail: <br>
        <input type="text" name ="email"/><br>
        Podaj swoje hasło:<br>
        <input type="password" name ="password"/><br><br>
        <input type="submit" value="Zaloguj się"/>
    </form>
    <p><a href="register.php">Zarejestruj się</a></p>
</body>
</html>

<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once 'confing.php';
    $conn = getDbConnetion();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows == false) {
            exit("Zły login<br>");
        } else {
            $row = $result->fetch_assoc();
            $_SESSION ['userId'] = $row['id'];
            $_SESSION ['username'] = $row['username'];
            $userPass = $row['hashedPassword'];
            if (!password_verify($password, $userPass)) {
                exit("Złe hasło<br>");
            }
        }
        
        $result->free_result();
        $_SESSION['login'] = true;
        $conn->close();
        $conn = null;
        header('Location: ../index.php');
    }
}
?>