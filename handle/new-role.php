<?php
include_once '../config/Data.php';
$data = new Data();
$connect = $data->connect();
$roleName = filter_input(INPUT_POST, 'role-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$dt = $_POST;
try {
  $roleID = $data->getMax('roles', 'roles');
  $role_permission = $data->getMax('rolePermissionID', 'role_permission');
  $sql = 'insert into roles(roles, roles_name) values(' . $roleID . ', "' . $roleName . '") ';
  $statement = $connect->prepare($sql);
  $check1 = $statement->execute();

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
  $check2 = $statement->execute();

  if ($check1 && $check2) {
    header('location: ../role.php');
  } else {
    echo "<script>alert('ERROR')</script>";
  }
} catch (PDOException $e) {
  echo "ERROR: " . $e->getMessage();
}



?>