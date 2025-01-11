<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$_SESSION['beginDate'] = date('Y-m-01');
$_SESSION['endDate'] = date('Y-m-d');

header('Location: summary.php');