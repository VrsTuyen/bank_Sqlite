<?php
include_once './../config/Data.php';
include_once './../function/function.php';
$data = new Data();
$connect = $data->connect();
$roleName = filter_input(INPUT_POST, 'role-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$roleID = $_POST['roleID'];
try {

  $sql = "update roles set roles_name = '$roleName' where roles ='$roleID'";
  $statement = $connect->prepare($sql);
  $check1 = $statement = $statement->execute();

  $sql = "delete from role_permission where roleID = '$roleID'";
  $statement = $connect->prepare($sql);
  $check2 = $statement = $statement->execute();

  $role_permission = $data->getMax('rolePermissionID', 'role_permission');

  $dt = $_POST;
  $sql = "insert into role_permission(rolePermissionID, roleID, permissionID) values ";
  $sqlValues = '';
  foreach ($dt as $key => $value) {
    if (is_integer($key)) {
      $sqlValues .= !empty($sqlValues) ? "," : "";
      $sqlValues .= "($role_permission, $roleID, $value )";
      $role_permission++;
    }
  }
  $sql = $sql . $sqlValues;
  $statement = $connect->prepare($sql);
  $check3 = $statement->execute();
  if ($check1 && $check2 && $check3) {

    header('location: ../role.php');
  } else {
    echo "<script>alert('ERROR')</script>";
  }
} catch (PDOException $e) {
  echo "<script>alert('ERROR')</script>";
}

?>