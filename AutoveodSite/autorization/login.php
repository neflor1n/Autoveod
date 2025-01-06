<?php
require_once ('../configuration/conf.php');
global $yhendus;

session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST["input"];
    $password = $_POST["password"];

    $paring = $yhendus->prepare("SELECT Id, Username, Password2, Email, Role FROM users WHERE Email = ? OR Username = ?");
    $paring->bind_param("ss", $input, $input);
    $paring->execute();
    $paring->bind_result($Id, $Username, $Password, $Email, $Role);


    if ($paring->fetch()) {
        if (password_verify($password, $Password)) {
            // Сохраняем данные в сессию
            $_SESSION['username'] = $Username;
            $_SESSION['email'] = $Email;
            $_SESSION['role'] = $Role;




            // Перенаправляем в зависимости от роли
            if ($Role === 'admin') {
                header("Location: ../veotellimuse_/veotellimuse.php");
                exit();
            } elseif ($Role === 'user') {
                header("Location: ../veotellimuse_/veotellimuse.php");
                exit();
            }
        } else {
            $error = "Vale parool või kasutajanimi!";
        }
    } else {
        $error = "Vale parool või kasutajanimi!";
    }
    $paring->close();
}



?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Styles/loginStyle.css">
    <title>Login</title>
</head>
<body>
    <div class="header">
        <h1 style="text-align: -webkit-center">Autorisation</h1>
    </div>

    <form class="form" action="?" method="post">
        <p class="form-title">Login into your account</p>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <div class="input-container">
            <input placeholder="Username/Email" type="text" name="input" required>
            <span>
                <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
            </span>

        </div>
        <div class="input-container">
            <input placeholder="password" type="password" name="password" required>
            <span>
                <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
            </span>
        </div>
        <button class="submit" type="submit">Login</button>
        <p class="signup-link">No account? <a href="reg.php">Registration</a></p>
    </form>


</body>
</html>
