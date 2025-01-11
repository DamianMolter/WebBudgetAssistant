<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$beginDate = date('Y-m-01', strtotime('-1 month'));
$endDate = date('Y-m-t', strtotime('-1 month'));

echo $beginDate.' / '.$endDate;