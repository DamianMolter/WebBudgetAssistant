<?php
session_start();

if (isset($_POST['email'])) {
      $everythingFine=true;
      
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      if (!ctype_alpha($name)) {
            $everythingFine=false;
            $_SESSION['nameError'] = '<span class="error">Imię musi składać się wyłącznie z liter!</span>';
            $_SESSION['givenName'] = $_POST['name'];
            //header("Location: register.php");
            //exit();
      }

} else {
      header('Location: register.php');
}





?>