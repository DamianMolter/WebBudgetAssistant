<?php
if (isset($isUserLogged)) {
      header('Location: index.html');
      exit();
}

$config = require_once 'connect.php';
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST["password"];


try {
      $db = new PDO("mysql:host={$config['host']}; dbname={$config['database']}; charset=utf8", $config['user'], $config['password'],[
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
} catch (PDOException $error) {
      exit('Database error');
}
