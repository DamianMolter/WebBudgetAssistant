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
            $loginQuery = $db->prepare('SELECT id, username, password FROM users WHERE email=:email');
            $loginQuery->bindValue(':email', $email, PDO::PARAM_STR);
            $loginQuery->execute();

            $user = $loginQuery->fetch();
			
			if($loginQuery->rowCount() == 0){
				$_SESSION['loginError']=true;
				$_SESSION['loginEmail']=$_POST['email'];
				$_SESSION['loginPassword']=$_POST['password'];
				
				header('Location: login.php');
			} else{
				if(password_verify($password, $user['password'])) {
                  $_SESSION['loggedUserId'] = $user['id'];
                  $_SESSION['loggedUserName'] = $user['username'];
                  unset($_SESSION['loginError']);
                  header('Location: summary-current-month.php');
                  exit();
            } else {
                  $_SESSION['loginError']=true;
                  $_SESSION['loginEmail']=$_POST['email'];
                  $_SESSION['loginPassword']=$_POST['password'];
                  header("Location: login.php");
                  exit();
            }
			}
      }
} else {
      header('Location: login.php');
      exit();
}

