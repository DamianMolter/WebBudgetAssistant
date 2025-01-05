<?php
session_start();

if (isset($_POST['email'])) {
      $everythingFine=true;
      
      $name = $_POST['name'];
      $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
      $password = $_POST['password'];

      if (!ctype_alpha($name)) {
            $everythingFine=false;
            $_SESSION['nameError'] = '<span class="error">Imię musi składać się wyłącznie z liter!</span>';
            $_SESSION['givenName'] = $_POST['name'];
      }

      if ($email != $_POST) {
            $everythingFine=false;
            $_SESSION['emailError'] = '<span class="error">Podany adres email jest nieprawidłowy!</span>';
            $_SESSION['givenEmail'] = $_POST['email'];
            //header("Location: register.php");
            //exit();
      }

} else {
      header('Location: register.php');
}





?>