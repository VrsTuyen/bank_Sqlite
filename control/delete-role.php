<?php
include_once('./../control/Data.php');
$data = new Data();
$connect = $data->connect();

$sql = 'delete from roles where roles = ' . $_GET['roleID'];

$check1 = $data->query($sql);
$sql = 'delete from role_permission where roleID = ' . $_GET['roleID'];
$check2 = $data->query($sql);
if ($check1 && $check2) {
  header('location: ../role.php');
} else {
  echo "<script>alert('ERROR')
    window.location.replace('../role.php');</script>";
}
?>