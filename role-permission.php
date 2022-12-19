<?php
session_start();
include_once('./control/Data.php');
include_once('./control/function.php');
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
$per = $statement->fetchAll();
$permission = [];
foreach ($per as $pms) {
  $permission[] = $pms['permissionID'];
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

            <form action="./control/role_permission.php" method="post" id="form">
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
                    <input type="checkbox" value="1" name="data[]" id="view-account" <?php if (in_array(1, $permission))
                      echo "checked=true" ?>>
                    <label for="view-account">View Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="2" name="data[]" id="insert-account" <?php if (
                      in_array(
                        2,
                        $permission
                      )
                    )
                      echo "checked=true" ?>>
                    <label for="insert-account">insert Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="3" name="data[]" id="edit-account" <?php if (in_array(3, $permission))
                      echo "checked=true" ?>>
                    <label for="edit-account">edit Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="4" name="data[]" id="delete-account" <?php if (
                      in_array(
                        4,
                        $permission
                      )
                    )
                      echo "checked=true" ?>>
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
                    <input type="checkbox" value="5" name="data[]" id="view-user" <?php if (in_array(5, $permission))
                      echo "checked=true" ?>>
                    <label for="view-user">View user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="6" name="data[]" id="insert-user" <?php if (in_array(6, $permission))
                      echo "checked=true" ?>>
                    <label for="insert-user">insert user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="7" name="data[]" id="edit-user" <?php if (in_array(7, $permission))
                      echo "checked=true" ?>>
                    <label for="edit-user">edit user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="8" name="data[]" id="delete-user" <?php if (in_array(8, $permission))
                      echo "checked=true" ?>>
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
                    <input type="checkbox" value="9" name="data[]" id="view-role" <?php if (in_array(9, $permission))
                      echo "checked=true" ?>>
                    <label for="view-role">View Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="10" name="data[]" id="insert-role" <?php if (
                      in_array(
                        10,
                        $permission
                      )
                    )
                      echo "checked=true" ?>>
                    <label for="insert-role">insert Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="11" name="data[]" id="edit-role" <?php if (in_array(11, $permission))
                      echo "checked=true" ?>>
                    <label for="edit-role">edit Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="12" name="data[]" id="delete-role" <?php if (
                      in_array(
                        12,
                        $permission
                      )
                    )
                      echo "checked=true" ?>>
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