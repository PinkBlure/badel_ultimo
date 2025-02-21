<?php

if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'centro') {
  setcookie('user_id', '', time() - 43200, '/');
  setcookie('user_email', '', time() - 43200, '/');
  setcookie('user_type', '', time() - 43200, '/');
}

if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'empresa') {
  setcookie('user_id', '', time() - 43200, "/");
  setcookie('user_cif', '', time() - 43200, "/");
  setcookie('user_type', '', time() - 43200, "/");
}

if (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'usuario') {
  setcookie('user_id', '', time() - 43200, "/");
  setcookie('user_dni', '', time() - 43200, "/");
  setcookie('user_type', '', time() - 43200, "/");
}

header('Location: ../../index.php');
exit();
