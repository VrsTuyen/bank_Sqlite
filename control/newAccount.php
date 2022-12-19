<?php
include_once './../control/Data.php';
$data = new Data();
$connect = $data->connect();

$balance = filter_input(INPUT_POST, 'info-balance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$fullName = filter_input(INPUT_POST, 'info-full_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$fullName = explode(" ", $fullName);
$firstName = $fullName[0] != '' ? $fullName[0] : '';
$lastName = $fullName[1] != '' ? $fullName[1] : '';
$age = filter_input(INPUT_POST, 'info-age', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$gender = filter_input(INPUT_POST, 'info-gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'info-address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$employer = filter_input(INPUT_POST, 'info-employer', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'info-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$city = filter_input(INPUT_POST, 'info-city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$state = filter_input(INPUT_POST, 'info-state', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

try {
  $account_number = $data->getMax('account_number', 'accounts');

  $sql = "INSERT INTO `accounts` (`account_number`, `balance`, `first_name`, `last_name`, `age`, `gender`, `address`, `employer`, `email`, `city`, `state`)
   VALUES ('$account_number', '$balance', '$firstName', '$lastName', '$age', '$gender', '$address', '$employer', '$email', '$city', '$state')";

  // $statement = $connect->prepare($sql);

  $data->query($sql);

  // $statement->bindParam(':balance', $balance);
  // $statement->bindParam(':firstName', $firstName);
  // $statement->bindParam(':lastName', $lastName);
  // $statement->bindParam(':age', $age);
  // $statement->bindParam(':gender', $gender);
  // $statement->bindParam(':address', $address);
  // $statement->bindParam(':email', $email);
  // $statement->bindParam(':city', $city);
  // $statement->bindParam(':state', $state);
  // $statement->bindParam(':employer', $employer);

  // $statement->execute();
  header('location: ./../index.php');

} catch (PDOException $e) {
  die("<h1> Error:" . $e->getMessage() . "</h1>");
}


?>