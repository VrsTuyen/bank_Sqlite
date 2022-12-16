<?php
include_once('./../config/Data.php');
$data = new Data();
$connect = $data->connect();

$sql = 'delete from roles where roles = ' . $_GET['roleID'];
$statement = $connect->prepare($sql);
$check = $statement->execute();
if ($check) {
  header('location: ../role.php');
} else {
  echo "<script>alert('ERROR')
    window.location.replace('../role.php');</script>";
}
?>