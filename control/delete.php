<?php
include_once('./../control/Data.php');
$data = new Data();
$connect = $data->connect();

$sql = "DELETE FROM accounts WHERE account_number = " . $_GET['account_number'] . "";

try {
  $data->query($sql);
  header('location: ../index.php');
} catch (PDOException $e) {
  die("<h1> Error: Something Went Wrong</h1>");

}

?>