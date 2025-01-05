<?php
session_start();

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST["password"];

if (isset($_POST['email'])) {
      if (empty($email)) {
            $_SESSION['loginError']=true;
            header('Location: login.php');
            exit();
      } else {
            require_once 'connect.php';
            $query = $db->prepare('SELECT email, password FROM users WHERE email=:email AND password = :password');
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->execute();

            $user = $query->fetch();

            if($user && $password == $user['password']) {
                  $_SESSION['isUserLogged']=true;
                  unset($_SESSION['loginError']);
                  header('Location: summary.php');
                  exit();
            } else {
                  $_SESSION['loginError']=true;
                  header("Location: login.php");
                  exit();
            }
      }
} else {
      header('Location: login.php');
      exit();
}

