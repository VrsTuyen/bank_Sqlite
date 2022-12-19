<?php
session_start();
include_once('./config/Data.php');
include_once('./function/function.php');
$data = new Data();
$connect = $data->connect();
$permissions = $_SESSION['permissions'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include_once('./layout/header.html');
  ?>
  <title>New Role</title>
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

            <form action="./handle/new-role.php" method="post" id="form">
              <div class="form-group">
                <div class="form-group-head">

                  <label for="role-name">
                    <h4 class="h4-heading">Role Name:</h4>
                  </label>
                  &emsp;
                  <div class="form-group-input">
                    <input type="text" name="role-name" id="role-name">
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
                    <input type="checkbox" value="1" name="data[]" id="view-account">
                    <label for="view-account">View Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="2" name="data[]" id="insert-account">
                    <label for="insert-account">insert Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="3" name="data[]" id="edit-account">
                    <label for="edit-account">edit Accounts</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="4" name="data[]" id="delete-account">
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
                    <input type="checkbox" value="5" name="data[]" id="view-user">
                    <label for="view-user">View user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="6" name="data[]" id="insert-user">
                    <label for="insert-user">insert user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="7" name="data[]" id="edit-user">
                    <label for="edit-user">edit user</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="8" name="data[]" id="delete-user">
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
                    <input type="checkbox" value="9" name="data[]" id="view-role">
                    <label for="view-role">View Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="10" name="data[]" id="insert-role">
                    <label for="insert-role">insert Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="11" name="data[]" id="edit-role">
                    <label for="edit-role">edit Roles</label>
                  </div>

                  <div class="col-3-lg col-3-xl col-3-md col-3-sm col-3-xs form-group-checkbox-element">
                    <input type="checkbox" value="12" name="data[]" id="delete-role">
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
      rules: [
        Validator.isRequired('#role-name', "Please enter role name"),
      ]
    })
  })
  </script>
</body>

</html>