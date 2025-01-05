<?php
session_start();

if (isset($_SESSION['nameError'])) {
      unset($_SESSION['nameError']);
}
if (isset($_SESSION['emailError'])) {
      unset($_SESSION['emailError']);
}
if (isset($_SESSION['passwordError'])) {
      unset($_SESSION['passwordError']);
}
if (isset($_SESSION['givenPasswordOne'])) {
      unset($_SESSION['givenPasswordOne']);
}
if (isset($_SESSION['givenPasswordTwo'])) {
      unset($_SESSION['givenPasswordTwo']);
}

header('Location: index.php');