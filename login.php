<?php
session_start();
include 'users.php';
$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];
  if (isset($usuarios[$usuario]) && password_verify($clave, $usuarios[$usuario]['password'])) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $usuarios[$usuario]['rol'];
    header("Location: panel_" . $_SESSION['rol'] . ".php");
    exit;
  } else {
    $error = "Usuario o contraseña incorrectos.";
  }
}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Login</title>
<link rel='stylesheet' href='style.css'></head><body><main>
<h2>Iniciar Sesión</h2>
<form method="post">
  <label>Usuario:</label><input type="text" name="usuario" required>
  <label>Contraseña:</label><input type="password" name="clave" required>
  <button type="submit">Entrar</button>
</form>
<?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>
</main></body></html>
