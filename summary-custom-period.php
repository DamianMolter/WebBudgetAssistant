<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$_SESSION['beginDate'] = $_POST['beginDate'];
$_SESSION['endDate'] = $_POST['endDate'];

header('Location: summary.php');