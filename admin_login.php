<?php
session_start();

// Credenciales del admin (en un proyecto real, usa password_hash y guarda en un archivo aparte)
$usuarios_permitidos = [
    'admin' => password_hash('password123', PASSWORD_BCRYPT) // Contraseña cifrada
];

// Verificar login
if ($_POST['login']) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($usuarios_permitidos[$username]) && password_verify($password, $usuarios_permitidos[$username])) {
        $_SESSION['admin'] = true;
        header('Location: admin_panel.php');
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}

// Mostrar formulario si no está logueado
if (!$_SESSION['admin']) {
    echo '
    <h2>Login Administrador</h2>
    <form method="POST">
        Usuario: <input type="text" name="username" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit" name="login">Ingresar</button>
    </form>';
    if (isset($error)) echo "<p style='color:red;'>$error</p>";
    exit;
}
?>