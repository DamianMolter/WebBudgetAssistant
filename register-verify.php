<?php
session_start();

if (isset($_POST['email'])) {
      $everythingFine = true;

      $name = $_POST['name'];
      $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
      $passwordOne = $_POST['passwordOne'];
      $passwordTwo = $_POST['passwordTwo'];

      if (!ctype_alpha($name)) {
            $everythingFine = false;
            $_SESSION['nameError'] = '<span class="error">Imię musi składać się wyłącznie z liter!</span>';
            $_SESSION['givenName'] = $_POST['name'];
      }

      if (strlen($name) <= 2) {
            $everythingFine = false;
            $_SESSION['nameError'] = '<span class="error">Powyższe pole musi być wypełnione - min. 3 znaki!</span>';
            $_SESSION['givenName'] = $_POST['name'];
      }

      if ($email != $_POST['email'] || empty($email)) {
            $everythingFine = false;
            $_SESSION['emailError'] = '<span class="error">Podany adres email jest nieprawidłowy!</span>';
            $_SESSION['givenEmail'] = $_POST['email'];
      }

      if (strlen($passwordOne) < 8 || strlen($passwordOne) > 20) {
            $everythingFine = false;
            $_SESSION['passwordError'] = '<span class="error">Długość hasła musi wynosić od 8 do 20 znaków!</span>';
      }

      if ($passwordOne != $passwordTwo) {
            $everythingFine = false;
            $_SESSION['passwordError'] = '<span class="error">Podane hasła nie są identyczne!</span>';
      }

      $_SESSION['givenPasswordOne'] = $_POST['passwordOne'];
      $_SESSION['givenPasswordTwo'] = $_POST['passwordTwo'];

      $hashedPassword = password_hash($passwordOne, PASSWORD_DEFAULT);

      $connect = require_once 'connect.php';

      $registerQuery = $db->prepare('SELECT email FROM users WHERE email=:email');
      $registerQuery->bindValue(':email', $email, PDO::PARAM_STR);
      $registerQuery->execute();

      $howManyRows = $registerQuery->fetchColumn();

      if ($howManyRows > 0) {
            $everythingFine = false;
            $_SESSION['emailError'] = '<span class="error">Na podany adres email istnieje już zarejestrowane konto!</span>';
            $_SESSION['givenEmail'] = $_POST['email'];
      }


      if (!$everythingFine) {
            header("Location: register.php");
            exit();
      } else {
            $query = $db->prepare('INSERT INTO users VALUES (NULL, :username, :password, :email)');
            $query->bindValue(':username', $name, PDO::PARAM_STR);
            $query->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();
      }

      header('Location: welcome.php');

} else {
      header('Location: register.php');
}