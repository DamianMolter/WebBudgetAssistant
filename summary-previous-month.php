<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$_SESSION['beginDate'] = date('Y-m-01', strtotime('-1 month'));
$_SESSION['endDate'] = date('Y-m-t', strtotime('-1 month'));

header('Location: summary.php');