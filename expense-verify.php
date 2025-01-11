<?php
session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
    }


if ($_POST['expenseCategory'] == 0 || $_POST['paymentMethod'] == 0 || $_POST['amount'] == null) {
      $_SESSION['inputError'] = true;
      $_SESSION['givenAmount'] = $_POST['amount'];
      header('Location: expense.php');
      exit();
}

if ($_POST['date']==NULL) {
      $date = date('Y-m-d');
}else{
      $date = $_POST['date'];
}

$amount = round($_POST['amount'], 2, PHP_ROUND_HALF_UP);
$paymentMethod = $_POST['paymentMethod'];
$expenseCategory = $_POST['expenseCategory'];
$expenseComment = $_POST['expenseComment'];

try {
      require_once 'connect.php';
      $saveNewExpenseQuery = $db->prepare('INSERT INTO expenses VALUES(NULL, :userId, :expenseCategory, :paymentMethod, :amount, :dateOfExpense, :expenseComment)');
      $saveNewExpenseQuery->bindValue(':userId', $_SESSION['loggedUserId'], PDO::PARAM_INT);
      $saveNewExpenseQuery->bindValue(':expenseCategory', $expenseCategory, PDO::PARAM_INT);
      $saveNewExpenseQuery->bindValue(':paymentMethod', $paymentMethod, PDO::PARAM_INT);
      $saveNewExpenseQuery->bindValue(':amount', $amount, PDO::PARAM_STR);
      $saveNewExpenseQuery->bindValue(':dateOfExpense', $date, PDO::PARAM_STR);
      $saveNewExpenseQuery->bindValue(':expenseComment', $expenseComment, PDO::PARAM_INT);
      $saveNewExpenseQuery->execute();
} catch (PDOException $error) {
      echo "Database error";
      sleep(5);
      header('Location: income.php');
}


$_SESSION['success'] = true;
header('Location: expense.php');