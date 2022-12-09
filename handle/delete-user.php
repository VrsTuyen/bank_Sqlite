<?php
session_start();
include_once('../config/Data.php');
include_once('role.php');
$is_admin = getRole($_SESSION['account']);

if ($is_admin) {
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