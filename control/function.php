<?php

function gender($gender)
{
  return strToLower($gender) == 'm' ? 'Male' : 'Female';
}

function checkPermission($permissions, $permission)
{
  return in_array($permission, $permissions);
}

function getPermissions($email, $connect)
{
  try {
    $permission = array();
    $sql = "SELECT permission.permissionType 
  FROM user INNER JOIN user_role on (user.userID = user_role.userID) 
  INNER JOIN roles on (user_role.roleID = roles.roles) 
  INNER JOIN role_permission on (roles.roles = role_permission.roleID) 
  INNER JOIN permission on (role_permission.permissionID = permission.permissionID) WHERE user.email = '$email';";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $permission[] = $row['permissionType'];
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
  return $permission;
}

?>