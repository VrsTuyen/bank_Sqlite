<?php
// include_once '../config/Data.php';

function getRole($email)
{
  $db = new Data();
  $connect = $db->connect();
  $sql = "SELECT COUNT (*)  FROM user,user_role 
  WHERE user.userID = user_role.userID AND user.email = '$email' and user_role.roleID = 0";
  echo $sql;

  $statement = $connect->prepare($sql);
  $statement->execute();
  $role = $statement->fetchColumn();
  return $role > 0 ? true : false;
}


?>