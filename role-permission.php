<?php
session_start();
include_once('./config/Data.php');
include_once('./function/function.php');
$data = new Data();
$connect = $data->connect();
$permissions = $_SESSION['permissions'];

$role = $_GET['roleID'];

$sql = "select roles_name from roles where roles = $role";
$statement = $connect->prepare($sql);
$statement->execute();
$role_name = $statement->fetchColumn();


$sql = "select permissionID from role_permission  INNER JOIN
roles ON role_permission.roleID = roles.roles where roleID = $role";
$statement = $connect->prepare($sql);
$statement->execute();
$permission = $statement->fetchAll();

function checkedPermission($value, $permission)
{
  foreach ($permission as $row) {
    if ($row['permissionID'] == $value) {
      echo "checked = true";
    }
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include_once('./layout/header.html');
  ?>
  <title></title>
</head>

<body>
  <div class="new-role">
    <?php
    include_once('./layout/navigation.php');

    ?>
    <div class="grid">
      <div class="row">
        <div class="col-12-lg col-12-xl col-12-md col-12-sm">
          <div class="content">

            <form action="./handle/role_permission.php" method="post" id="form">
              <input type="checkbox" name="roleID" hidden checked value="<?php echo $_GET['roleID'] ?>">
              <div class="form-group">
                <div class="form-group-head">

                  <label for="role-name">
                    <h4 class="h4-heading">Role Name:</h4>
                  </label>
                  &emsp;
                  <div class="form-group-input">
                    <input type="text" name="role-name" id="role-name" value="<?= $role_name ?>">
                  </div>
                  &emsp;
                  <p class="validation-message"></p>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <div class="form-group-full">
                  <input type="checkbox" name="full-accounts" id="full-accounts">
                  <label for="full-accounts">Accounts</label>
                </div>
                <br>
                <div class="form-group-checkbox">

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="1" name="1" id="view-account" <?php checkedPermission(
                      1,
                      $permission
                    ) ?>>
                    <label for="view-account">View Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="2" name="2" id="insert-account" <?php checkedPermission(
                      2,
                      $permission
                    ) ?>>
                    <label for="insert-account">insert Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="3" name="3" id="edit-account" <?php checkedPermission(3, $permission)
                      ?>>
                    <label for="edit-account">edit Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="4" name="4" id="delete-account" <?php checkedPermission(
                      4,
                      $permission
                    ) ?>>
                    <label for="delete-account">delete Accounts</label>
                  </div>

                </div>

              </div>
              <hr>
              <div class="form-group">

                <div class="form-group-full">
                  <input type="checkbox" name="full-users" id="full-users">
                  <label for="full-users">user</label>
                </div>
                <div class="form-group-checkbox">
                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="5" name="5" id="view-user" <?php checkedPermission(5, $permission) ?>>
                    <label for="view-user">View user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="6" name="6" id="insert-user" <?php checkedPermission(6,
                      $permission) ?>>
                    <label for="insert-user">insert user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="7" name="7" id="edit-user" <?php checkedPermission(7, $permission) ?>>
                    <label for="edit-user">edit user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="8" name="8" id="delete-user" <?php checkedPermission(8,
                      $permission) ?>>
                    <label for="delete-user">delete user</label>
                  </div>
                </div>
              </div>
              <hr>

              <div class="form-group">
                <div class="form-group-full">
                  <input type="checkbox" name="full-roles" id="full-roles">
                  <label for="full-roles">Roles</label>
                </div>
                <div class="form-group-checkbox">

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs   form-group-checkbox-element">
                    <input type="checkbox" value="9" name="9" id="view-role" <?php checkedPermission(9, $permission) ?>>
                    <label for="view-role">View Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="10" name="10" id="insert-role" <?php checkedPermission(
                      10,
                      $permission
                    ) ?>>
                    <label for="insert-role">insert Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="11" name="11" id="edit-role" <?php checkedPermission(11,
                      $permission) ?>>
                    <label for="edit-role">edit Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="12" name="12" id="delete-role" <?php checkedPermission(
                      12,
                      $permission
                    ) ?>>
                    <label for="delete-role">delete Roles</label>
                  </div>

                </div>
              </div>
              <hr>
              <div class="form-submit">
                <input type="submit" value="save" name="role-submit">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/js/main.js"></script>

  <script src="./assets/js/new-role.js"></script>
  <script src="./assets/js/validate.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    Validator({
      form: '#form',
      formGroupSelector: '.form-group',
      errorSelector: ".validation-message",
      rules: [Validator.isRequired('#role-name', "Please enter role name"), ]
    })
  })
  </script>
</body>

</html>