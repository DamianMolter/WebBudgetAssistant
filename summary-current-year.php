<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$beginDate = date('Y-01-01');
$endDate = date('Y-12-31');

echo $beginDate.' / '.$endDate;