<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$beginDate = $_POST['beginDate'];
$endDate = $_POST['endDate'];

echo $beginDate.' / '.$endDate;