<?php
$usuarios = [
  "juan" => ["password" => password_hash("clave123", PASSWORD_DEFAULT), "rol" => "operario"],
  "ana"  => ["password" => password_hash("admin123", PASSWORD_DEFAULT), "rol" => "supervisor"]
];
?>