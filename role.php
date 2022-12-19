<?php
session_start();
require_once('./control/Data.php');
require_once('./control/function.php');
$data = new Data();
$connect = $data->connect();
$permissions = getPermissions($_SESSION['account'], $connect);
if (!checkPermission($permissions, 'view-role')) {
  header('location:index.php');
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

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include_once('./layout/header.html');
  ?>
  <title>Role</title>
</head>

<body>
  <div class="main">
    <?php include_once('./layout/navigation.php') ?>
    <div class="grid">
      <div class="row">
        <div class="col-12-xl col-12-lg col-12-md col-12-sm col-12-xs">
          <div class="content">
            <div class="content-header">
              <?php if (checkPermission($permissions, 'insert-role')) { ?>
              <a href="./new-role.php" class="primary-button">new role</a>
              <?php } ?>
            </div>
          </div>
          <div class="content-container">
            <table class="content-container-table">
              <thead class="">
                <th>Role ID</th>
                <th>Role name</th>
                <th>Use</th>
                <?php if (checkPermission($permissions, 'edit-role') || checkPermission($permissions, 'delete-role')) { ?>
                <th></th>
                <?php } ?>
              </thead>
              <tbody class="content-container-table-body">
                <?php
                $sql = "select * from roles";
                $result = $data->read($sql);

                foreach ($result as $row) {
                  echo "
                    <tr>
                      <td>" . $row['roles'] . "</td>
                      <td>" . $row['roles_name'] . "</td>";
                  $sql = "SELECT count( * ) 
                  FROM user_role
                       INNER JOIN
                       user
                 WHERE user_role.userID = user.userID AND 
                       user_role.roleID = 0;";
                  $total = $data->countTotal(" user_role
                  INNER JOIN
                  user
                  WHERE user_role.userID = user.userID AND 
                  user_role.roleID =" . $row['roles']);
                  echo "<td>$total</td>";
                  if (checkPermission($permissions, 'edit-role') || checkPermission($permissions, 'delete-role')) {
                    echo "<td width='140px'>";
                  }

                  if (checkPermission($permissions, 'edit-role')) {
                    echo "<a href='role-permission.php?roleID=" . $row['roles'] . "' class='link-icon' title='Permission'><i class='fa-solid fa-user-gear'></i></a>";
                  }
                  if (checkPermission($permissions, 'delete-role')) {
                    echo "<a href='control/delete-role.php?roleID=" . $row['roles'] . "' class='link-icon' onclick='return showMessageDelete(this)' title='Delete'>
                    <i class='red-color fa-solid fa-trash'></i></a>";
                  }
                  echo "</td>
                    </tr>
                  ";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/js/main.js"></script>

  <script type="text/javascript">
  function showMessageDelete($data) {
    if (confirm('Are you sure?')) {
      $.doAjax()
    }
    return false;
  }
  </script>
</body>

</html>