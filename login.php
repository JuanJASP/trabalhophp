<?php
session_start();

$usuarioCorreto = "admin";
$senhaHash = password_hash("1234", PASSWORD_DEFAULT);
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    if ($usuario === $usuarioCorreto && password_verify($senha, $senhaHash)) {
        $_SESSION["logado"] = true;
        header("Location: index.php");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal {
            width: 350px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
        }

        h2 {
            color: #555;
            margin-bottom: 20px;
        }
        .entrar{
            color: white;
             font-family: Arial;

        }

        input, button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            box-sizing: border-box;
        }
        

        input {
            border: 1px solid #ccc;
        }

        button {
            background-color: #2d6cdf;
            color: gray;
            border: none;
            cursor: pointer;
        }

        .erro {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="modal">

    <h1>Gestor Financeiro Pessoal</h1>
    <h2>Login</h2>

    <?php if ($erro != ""): ?>
        <p class="erro"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuário" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <button type="submit" class="entrar">Entrar</button>
    </form>

</div>

</body>
</html>