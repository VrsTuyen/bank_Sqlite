<?php
session_start();
include_once('../config/Data.php');
include_once('../function/function.php');
include_once('role.php');
$permissions = $_SESSION['permissions'];
// $is_admin = getRole($_SESSION['account']);

if (checkPermission($permissions, 'edit-user')) {
  $data = new Data();
  $connect = $data->connect();

  $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $userID = $data->getID("userID", "user", "where email = '$email'");

  // $userID = (string) $userID;

  try {
    $sql = "DELETE FROM `user` WHERE `user`.`email` = '$email';";
    $statement = $connect->prepare($sql);
    $statement->execute();

    $sql = "delete from user_role where userID = '$userID'";
    $statement = $connect->prepare($sql);
    $statement->execute();

    header('location: ../user.php');
  } catch (PDOException $e) {
    echo "<h1> Error:" . $e->getMessage() . "</h1>";
  }

} else {
  header('location: ../index.php');
}
?>