<?php
if (isset($isUserLogged)) {
      header('Location: index.html');
      exit();
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST["password"];

if (isset($_POST['email'])) {
      if (empty($email)) {
            
      } else {
            require_once 'connect.php';
            $query = $db->prepare('SELECT email, password FROM users WHERE email=:email AND password = :password');
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->execute();

            $user = $query->fetch();

            if($user && $password == $user['password']) {
                  header('Location: summary.html');
                  exit();
            } else {
                  echo 'Błędne dane logowania';
            }
      }
} else {
      header('Location: index.html');
      exit();
}

