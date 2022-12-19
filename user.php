<?php
session_start();
include_once './control/Data.php';
include_once './control/function.php';

$data = new Data();
$connect = $data->connect();

$permissions = getPermissions($_SESSION['account'], $connect);

// // $is_admin = getRole($_SESSION['account']);
// $permissions = $_SESSION['permissions'];

if (!checkPermission($permissions, 'view-user')) {
  header('location: index.php');
}

if (!empty(isset($validate))) {
  header("Location: $strURI");
}

if (isset($_GET['message'])) {
  $message = $_GET['message'];
  echo "<script> alert('$message') </script>";
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
  <title>User</title>
</head>

<body>
  <div class="user">
    <?php
    include_once "./layout/navigation.php";
    ?>
    <div class="grid">
      <div class="row">
        <div class="col-12-xl col-12-lg">
          <div class="user-header">
            <?php
            if (checkPermission($permissions, 'insert-user')) {
            ?>
            <a href="?new-user" class="user-header-button">Add User</a>
            <?php
            }
            ?>
          </div>
          <?php
          if (checkPermission($permissions, 'view-user')) {
          ?>
          <table class="user-table">
            <thead>
              <tr>
                <th>UserName</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Role</th>
                <th>Country</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
            $sql = 'SELECT user.username, phone, email, password, roles.roles_name as roles, country
              FROM user, roles, user_role
              WHERE user_role.roleID = roles.roles
              AND user.userID = user_role.userID
              AND NOT user.email = "' . $_SESSION['account'] . '"
              ORDER BY user.username ASC';

            $statement = $connect->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $colCount = $statement->columnCount();
            $str = '';
            for ($i = 0; $i <= count($result) - 1; $i++) {
              $str .= "<tr>
              <td>" . $result[$i]['username'] . "</td>
              <td>" . $result[$i]['phone'] . "</td>
              <td>" . $result[$i]['email'] . "</td>
              <td>" . $result[$i]['roles'] . "</td>
              <td>" . $result[$i]['country'] . "</td>";
              if (checkPermission($permissions, 'edit-user')) {
                $str .= "<td><a href = '?user-email=" . $result[$i]['email'] . "' class ='link-icon'>
              <i class='fi fi-sr-eye'></i></a></td>";
              }
              if (checkPermission($permissions, 'delete-user')) {
                $str .= "<td><a href = './control/delete-user.php?email=" . $result[$i]['email'] . "' onclick = 'return showMessageDelete(this)' class = 'link-icon'>
                <i class='red-color fa-solid fa-trash'></i></a>
                </td>";
              }

              $str .= "</tr> ";
            }
            echo $str;
              ?>
            </tbody>
          </table>
          <?php } else {
            header('location: index.php');
          } ?>
        </div>
      </div>
    </div>
  </div>
  <?php

  // lay du lieu de do len form
  if (isset($_GET['user-email'])) {
    try {
      $email = $_GET['user-email'];
      $sql = "SELECT user.userID, username, phone, password, country, roles.roles FROM user, user_role, roles WHERE user_role.roleID = roles.roles AND user.userID = user_role.userID AND email = '$email';";

      $statement = $connect->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      $userName = '';
      $phone = '';
      $password = '';
      $country = '';
      $role = '';
      $userID = '';
      foreach ($result as $user) {
        $userID = $user['userID'];
        $userName = $user['username'];
        $phone = $user['phone'];
        $password = $user['password'];
        $role = $user['roles'];
        $country = $user['country'];
      }
    } catch (PDOException $e) {
      die("<h1> Error:" . $e->getMessage() . "</h1>");
    }
  }
  ?>

  <div class="overlay
  <?php
  if (isset($_GET['user-email']) || isset($_GET['new-user']))
    echo 'active';
  ?>">
    <div class="overlay-info" <?php echo "style='max-width: 500px'"; ?>>
      <div class="overlay-info-heading">
        <h2 class="h2-heading">
          <?php echo isset($_GET['user-email']) ? 'Edit' : 'New' ?>
        </h2>
      </div>
      <form
        action="<?php echo isset($_GET['user-email']) ? './control/edit-user.php' : (isset($_GET['new-user']) ? './control/new-user.php' : '') ?>"
        method="post"
        class="<?php echo isset($_GET['user-email']) ? 'form-edit' : (isset($_GET['new-user']) ? 'form-new' : '') ?>">
        <div class="form-group">
          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">Username</h4>
            <input type='text' name='info-username' class="input-text input-username"
              value='<?= isset($userName) ? $userName : (isset($_SESSION['add-new-add-user']) ? $_SESSION['add-new-user']['username'] : '') ?>'>
          </div>
          <p class="validation-message"></p>
        </div>
        <div class="form-group">
          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">Phone</h4>
            <input type='tel' name='info-phone' class="input-text input-phone"
              value='<?= isset($phone) ? $phone : (isset($_SESSION['add-new-add-user']) ? $_SESSION['add-new-user']['phone'] : ''); ?>'>
          </div>
          <p class="validation-message"></p>
        </div>

        <div class="form-group">
          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">Email</h4>
            <input type='email' name='info-email' class="input-text input-email" value=<?php if
              (isset($_GET['user-email'])) { echo "'" . $_GET['user-email'] . "' readonly"; } else { echo
              isset($_SESSION['add-new-add-user']) ? $_SESSION['add-new-user']['email'] : ''; } ?>>
          </div>
          <p class="validation-message"></p>
        </div>

        <div class="form-group">
          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">Password</h4>
            <input type='password' name='info-password'
              value='<?= isset($password) ? $password : (isset($_SESSION['add-new-add-user']) ? $_SESSION['add-new-user']['password'] : ''); ?>'
              class="input-text input-password">
          </div>
          <p class="validation-message"></p>
        </div>

        <?php
        if (isset($_GET['new-user'])) {
        ?>

        <div class="form-group">
          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">Confirm Password</h4>
            <input type='password' name='info-password-repeat'
              value='<?= isset($confirmPassword) ? $confirmPassword : (isset($_SESSION['add-new-add-user']) ? $_SESSION['add-new-user']['repeatPassword'] : ''); ?>'
              class="input-text input-password-confirm">
          </div>
          <p class="validation-message"></p>
        </div>

        <?php } ?>
        <div class="overlay-info-content-wrap">
          <h4 class="h4-heading">Role</h4>
          <select name="info-role" id="" class="select"
            value='<?php isset($role) ? $role : (isset($_SESSION['add-new-add-user']) ? $_SESSION['add-new-user']['role'] : ''); ?>'>
            <?php
            $sql = "SELECT * FROM roles";
            $statement = $connect->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
              if ($row['roles'] == $role) {
                echo "<option selected value  = '" . $row['roles'] . "'>" . $row['roles_name'] . "</option>";
              } else {
                echo "<option value  = '" . $row['roles'] . "'>" . $row['roles_name'] . "</option>";
              }
            }
            ?>
          </select>
        </div>

        <div class="form-group">
          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">Country</h4>
            <input type='country' name='info-country' class="input-text input-country"
              value='<?= isset($country) ? $country : (isset($_SESSION['add-new-add-user']) ? $_SESSION['add-new-user']['country'] : ''); ?>'>
          </div>
          <p class="validation-message"></p>
        </div>
        <div class="overlay-info-content-wrap">
          <p class="validate">
            <?php
            echo isset($validate) ? $validate : '';
            ?>
          </p>
        </div>
        <div class="overlay-info-button-wrap">
          <input type="submit" value="save" name='submit-form' ?>
          <a href="user.php" class="overlay-info-button-wrap-btn">close</a>
        </div>
      </form>
    </div>
  </div>

  <script src="./assets/js/main.js"></script>
  <script src="./assets/js/validate.js"></script>

  <!-- validation -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    Validator({
      form: '.form-new',
      formGroupSelector: '.form-group',
      errorSelector: ".validation-message",
      rules: [
        Validator.isRequired('.input-username', "Please enter user name"),
        Validator.isRequired('.input-phone', "Please enter your phone number"),
        Validator.minLength('.input-phone', 10, 'Please enter your phone number correctly'),
        Validator.maxLength('.input-phone', 10, 'Please enter your phone number correctly'),
        Validator.isNumber('.input-phone', 'Please enter your phone number correctly'),
        Validator.isRequired('.input-email', 'Please enter your email'),
        Validator.isEmail('.input-email', 'Please enter your email correctly'),
        Validator.isRequired('.input-password', 'Please enter your password'),
        Validator.isConfirmed('.input-password-confirm', function() {
          return document.querySelector('.form-new .input-password').value
        }, 'Password incorrect, please try again'),
        Validator.maxLength('.input-country', 2, 'Enter up to 2 characters'),
      ],

    })
    Validator({
      form: '.form-edit',
      formGroupSelector: '.form-group',
      errorSelector: ".validation-message",
      rules: [
        Validator.isRequired('.input-username', "Please enter user name"),
        Validator.isRequired('.input-phone', "Please enter your phone number"),
        Validator.minLength('.input-phone', 10, 'Please enter your phone number correctly'),
        Validator.maxLength('.input-phone', 10, 'Please enter your phone number correctly'),
        Validator.isNumber('.input-phone', 'Please enter your phone number correctly'),
        Validator.isRequired('.input-email', 'Please enter your email'),
        Validator.isEmail('.input-email', 'Please enter your email correctly'),
        Validator.isRequired('.input-password', 'Please enter your password'),
        Validator.maxLength('.input-country', 2, 'Enter up to 2 characters'),
      ],

    })
  });
  </script>

</body>

</html>