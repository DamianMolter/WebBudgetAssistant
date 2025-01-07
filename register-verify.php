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

      $repeatingEmailQuery = $db->prepare('SELECT email FROM users WHERE email=:email');
      $repeatingEmailQuery->bindValue(':email', $email, PDO::PARAM_STR);
      $repeatingEmailQuery->execute();

      $howManyRows = $repeatingEmailQuery->fetchColumn();

      if ($howManyRows > 0) {
            $everythingFine = false;
            $_SESSION['emailError'] = '<span class="error">Na podany adres email istnieje już zarejestrowane konto!</span>';
            $_SESSION['givenEmail'] = $_POST['email'];
      }


      if (!$everythingFine) {
            header("Location: register.php");
            exit();
      } else {
            $registerQuery = $db->prepare('INSERT INTO users VALUES (NULL, :username, :password, :email)');
            $registerQuery->bindValue(':username', $name, PDO::PARAM_STR);
            $registerQuery->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $registerQuery->bindValue(':email', $email, PDO::PARAM_STR);
            $registerQuery->execute();

            $newUserQuery = $db->prepare('SELECT id FROM users WHERE email=:email');
            $newUserQuery->bindValue(':email', $email, PDO::PARAM_STR);
            $newUserQuery->execute();

            $newUser = $newUserQuery->fetch();
            $newUserId = $newUser['id'];

            $setIncomeDefaultCategoriesQuery = $db->prepare('INSERT INTO incomes_category_assigned_to_users (id, user_id, name)
                                                                  SELECT NULL, :user_id, name FROM incomes_category_default');
            $setIncomeDefaultCategoriesQuery->bindValue(':user_id', $newUserId, PDO::PARAM_INT);
            $setIncomeDefaultCategoriesQuery->execute();

            $setExpenseDefaultCategoriesQuery = $db->prepare('INSERT INTO expenses_category_assigned_to_users (id, user_id, name)
                                                                  SELECT NULL, :user_id, name FROM expenses_category_default');
            $setExpenseDefaultCategoriesQuery->bindValue(':user_id', $newUserId, PDO::PARAM_INT);
            $setExpenseDefaultCategoriesQuery->execute();

            $setPaymentMethodDefaultCategoriesQuery = $db->prepare('INSERT INTO payment_methods_assigned_to_users (id, user_id, name)
                                                                  SELECT NULL, :user_id, name FROM payment_methods_default');
            $setPaymentMethodDefaultCategoriesQuery->bindValue(':user_id', $newUserId, PDO::PARAM_INT);
            $setPaymentMethodDefaultCategoriesQuery->execute();
      }

      header('Location: welcome.php');
      $_SESSION['registerSuccessfull']  = true;

} else {
      header('Location: register.php');
}