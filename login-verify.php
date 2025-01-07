<?php
session_start();

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST["password"];

if (isset($_POST['email'])) {
      if (empty($email)) {
            $_SESSION['loginError']=true;
            $_SESSION['loginEmail']=$_POST['email'];
            $_SESSION['loginPassword']=$_POST['password'];
            header('Location: login.php');
            exit();
      } else {
            require_once 'connect.php';
            $loginQuery = $db->prepare('SELECT id, email, password FROM users WHERE email=:email');
            $loginQuery->bindValue(':email', $email, PDO::PARAM_STR);
            $loginQuery->execute();

            $user = $loginQuery->fetch();

            if(password_verify($password, $user['password'])) {
                  $_SESSION['loggedUserId'] = $user['id'];
                  unset($_SESSION['loginError']);
                  header('Location: summary.php');
                  exit();
            } else {
                  $_SESSION['loginError']=true;
                  $_SESSION['loginEmail']=$_POST['email'];
                  $_SESSION['loginPassword']=$_POST['password'];
                  header("Location: login.php");
                  exit();
            }
      }
} else {
      header('Location: login.php');
      exit();
}

