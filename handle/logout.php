<?php
session_start();
$_SESSION['account'] = null;
unset($_SESSION['account']);
$_SESSION['permissions'] = null;
unset($_SESSION['permissions']);
header('location: ./../index.php');

?>