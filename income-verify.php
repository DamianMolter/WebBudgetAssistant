<?php
session_start();
$amount = round($_POST['amount'],2,PHP_ROUND_HALF_UP);
$date = $_POST['date'];
$incomeCategory = $_POST['incomeCategory'];
$incomeComment = $_POST['incomeComment'];

try {
      require_once 'connect.php';

$saveNewIncomeQuery = $db->prepare('INSERT INTO incomes VALUES(NULL, :userId, :incomeCategory, :amount, :dateOfIncome, :incomeComment)');
                    $saveNewIncomeQuery->bindValue(':userId', $_SESSION['loggedUserId'], PDO::PARAM_INT);
                    $saveNewIncomeQuery->bindValue(':incomeCategory', $incomeCategory, PDO::PARAM_INT);
                    $saveNewIncomeQuery->bindValue(':amount', $amount, PDO::PARAM_STR);
                    $saveNewIncomeQuery->bindValue(':dateOfIncome', $date, PDO::PARAM_STR);
                    $saveNewIncomeQuery->bindValue(':incomeComment', $incomeComment, PDO::PARAM_INT);
                    $saveNewIncomeQuery->execute();
} catch (PDOException $error) {
      echo "Database error";
      sleep(5);
      header('Location: income.php');
}


$_SESSION['success']=true;
header('Location: income.php');