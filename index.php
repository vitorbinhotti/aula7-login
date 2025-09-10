<?php
// login.php

// 1) Conexão
$mysqli = new mysqli("localhost", "root", "root", "login_db");
if ($mysqli->connect_errno) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

session_start();

// 2) Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// 3) Login
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST["username"] ?? "";
    $pass = $_POST["password"] ?? "";

    $stmt = $mysqli->prepare("SELECT pk, username, senha FROM usuarios WHERE username=? AND senha=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();
    $stmt->close();

    if ($dados) {
        $_SESSION["user_pk"] = $dados["pk"];
        $_SESSION["username"] = $dados["username"];
        header("Location: index.php");
        exit;
    } else {
        $msg = "Usuário ou senha incorretos!";
    }
}
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Login Simples</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php if (!empty($_SESSION["user_pk"])): ?>
        <div class="card">
            <h3>Bem-vindo, <?= $_SESSION["username"] ?>!</h3>
            <h4>Aulas de Hoje!</h4>
            <div class="aulas">
                <p>Fit Dance - 09:15</p>
                <p>Super Glúteos - 11:15</p>
                <p>Muay Thai - 16:15</p>
                <p>Boxe - 18:10</p>
                <p>Funcional - 19:15</p>
            </div>
            <a href="?logout=1" class="btn-logout">Sair</a>


        <?php else: ?>
            <div class="card">
                <h3>Login</h3>
                <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
                <form method="post">
                    <input type="text" name="username" placeholder="Usuário" required>
                    <input type="password" name="password" placeholder="Senha" required>
                    <p>Dica: admin / 123</p>
                    <button type="submit">Entrar</button>
                </form>
            </div>
            <h1 class="titulo">Venha fazer parte da nossa academia!</h1>
        <?php endif; ?>

</body>

</html>