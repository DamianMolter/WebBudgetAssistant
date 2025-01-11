<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$_SESSION['beginDate'] = date('Y-01-01');
$_SESSION['endDate'] = date('Y-12-31');

header('Location: summary.php');