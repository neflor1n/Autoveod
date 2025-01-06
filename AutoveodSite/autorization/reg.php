<?php
require_once("../configuration/conf.php");
global $yhendus;

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = "user";

    // Проверка, что пользователь с таким email или username не существует
    $check_query = $yhendus->prepare("SELECT Id FROM users WHERE Email = ? OR Username = ?");
    $check_query->bind_param("ss", $email, $username);
    $check_query->execute();
    $check_query->store_result();

    if ($check_query->num_rows > 0) {
        $error = "Sama e-posti aadressi või nimega kasutaja on juba olemas!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        // Добавляем пользователя в базу данных
        $insert_query = $yhendus->prepare("INSERT INTO users (Username, Email, Password, Password2, Role) VALUES (?, ?, ?, ?, ?)");
        $insert_query->bind_param("sssss", $username, $email, $password, $hashed_password, $role);


        if ($insert_query->execute()) {
            $success = "Registreerimine õnnestus! Nüüd saate sisse logida.";
        } else {
            $error = "Viga registreerimisel!";
        }

        $insert_query->close();
    }

    $check_query->close();
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Regitration</title>
    <link rel="stylesheet" href="../Styles/loginStyle.css">
</head>
<body>

<header>
    <h1 style="text-align: -webkit-center">Registration</h1>
</header>


<form class="form" action="?" method="post">
    <p class="form-title">Create an account</p>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <div class="input-container">
        <input placeholder="Username" type="text" name="username" required>
    </div>
    <div class="input-container">
        <input placeholder="Email" type="email" name="email" required>
    </div>
    <div class="input-container">
        <input placeholder="Password" type="password" name="password" required>
    </div>
    <button class="submit" type="submit">Loo uus konto</button>

    <p class="signup-link">
        Have account?
        <a href="login.php">Login</a>
    </p>
</form>

</body>
</html>
