<?php
session_start();

if (isset($_POST['email'])) {
      $everythingFine=true;
      
      $name = $_POST['name'];
      $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
      $passwordOne = $_POST['passwordOne'];
      $passwordTwo = $_POST['passwordTwo'];

      if (!ctype_alpha($name)) {
            $everythingFine=false;
            $_SESSION['nameError'] = '<span class="error">Imię musi składać się wyłącznie z liter!</span>';
            $_SESSION['givenName'] = $_POST['name'];
      }

      if ($email != $_POST['email']) {
            $everythingFine=false;
            $_SESSION['emailError'] = '<span class="error">Podany adres email jest nieprawidłowy!</span>';
            $_SESSION['givenEmail'] = $_POST['email'];
      }

      if (strlen($passwordOne) < 8 || strlen($passwordOne) > 20 ) {
            $everythingFine=false;
            $_SESSION['passwordError'] = '<span class="error">Długość hasła musi wynosić od 8 do 20 znaków!</span>';
      }

      if ($passwordOne != $passwordTwo) {
            $everythingFine=false;
            $_SESSION['passwordError'] = '<span class="error">Podane hasła nie są identyczne!</span>';
            header("Location: register.php");
            exit();
      }

      

} else {
      header('Location: register.php');
}





?>