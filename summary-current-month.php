<?php

session_start();
if (!isset($_SESSION['loggedUserId'])) {
      header('Location: login.php');
      exit();
}

$beginDate = date('Y-m-01');
$endDate = date('Y-m-d');

echo $beginDate.' / '.$endDate;