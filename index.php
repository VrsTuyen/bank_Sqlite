<?php
session_start();
include './config/Data.php';
include_once('./function/function.php');


$data = new Data();
$connect = $data->connect();

if (empty($_SESSION['account'])) {
  header('location: login.php');
}

$email = $_SESSION['account'];
// $is_admin = getRole($email);



$permissions = getPermissions($email);


$_SESSION['permissions'] = $permissions;

$limit = 15;
$page = 1;

if (isset($_GET['page'])) {
  $page = $_GET['page'];
  $start = (($page - 1) * $limit);
} else {
  $start = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include_once('./layout/header.html')
    ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <title>Bank Accounts</title>
</head>

<body>
  <header>
  </header>
  <div class="main">
    <?php include_once "./layout/navigation.php"; ?>
    <div class="grid">
      <div class="row">
        <div class="col-12-xl col-12-lg col-12-md col-12-sm col-12-xs">
          <div class="content">
            <div class="content-header">

              <?php if (checkPermission($permissions, 'insert-account')) { ?>
              <div class="content-header-insert">
                <a href="?addNew">new account</a>
              </div>
              <?php } ?>

            </div>
          </div>
          <?php
          if (checkPermission($permissions, 'view-account')) {
          ?>

          <div class="content-container">
          </div>

          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  </div>
  <?php
  if (isset($_GET['account_number'])) {
    include_once './handle/info.php';
    echo "<div class='overlay active'>";
  ?>
  <div class="overlay-info">
    <div class="overlay-info-heading">
      <h2 class="h2-heading">Edit</h2>
    </div>

    <form action="<?php echo isset($addNew) ? './handle/new.php' : './handle/edit.php' ?>" method="post" id="form">
      <div class="overlay-info-content">
        <div class="overlay-info-content-left">

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">account number</h4>
              <input type='text' name='info-account_number' value='<?= $account_number ?>' readonly
                class="input-text input-account-number">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">full name</h4>
              <input type='text' name='info-full_name' value='<?= $fullName ?>' class="input-text input-full_name">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading"> balance </h4>
              <input type='number' min="0" name='info-balance' value='<?= $balance ?>' class="input-text input-balance">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">age </h4>
              <input type="number" name='info-age' class="input-text input-age" value="<?= $age ?>" min="18" max="100"
                step="1">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="overlay-info-content-wrap overlay-info-content-wrap-gender">
            <h4 class="h4-heading">gender </h4>
            <?php
    if ($gender == 'Male') {
      echo "
            <div class='overlay-info-content-wrap-radio'>
            <input type='radio' name='info-gender' id = 'info-gender-m' value='M' checked>
            <label for='info-gender-m'>Male</label>
          </div>
          <div class='overlay-info-content-wrap-radio'>
            <input type='radio' name='info-gender' id = 'info-gender-f' value='F'>
            <label for='info-gender-f'>Female</label>
          </div>
            ";
    } else {
      echo "
            <div class='overlay-info-content-wrap-radio'>
            <input type='radio' name='info-gender' id = 'info-account-gender-m' value='M' >
            <label for='info-account-gender-m'>Male</label>
          </div>
          <div class='overlay-info-content-wrap-radio'>
            <input type='radio' name='info-gender' id = 'info-account-gender-f' value='F' checked>
            <label for='info-account-gender-f'>Female</label>
          </div>
            ";
    }
            ?>
          </div>
        </div>

        <div class="overlay-info-content-right">

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">address </h4>
              <input type="text" name='info-address' class="input-text input-address" value="<?= $address ?>">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">city </h4>
              <input type="text" name='info-city' class="input-text input-city" value="<?= $city ?>">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">state </h4>
            <!-- <input type="state" name='info-state' class="" value="<?= $state ?>"> -->
            <select name="info-state" id="" class="select">
              <?php
    $sql = 'SELECT * FROM state';
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      if ($row['state'] == $state) {
        echo "<option selected value  = '" . $row['state'] . "'>" . $row['name'] . "</option>";
      } else {
        echo "<option value  = '" . $row['state'] . "'>" . $row['name'] . "</option>";
      }
    }
              ?>
            </select>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">employer </h4>
              <input type="text" name='info-employer' class="input-text input-employer" value="<?= $employer ?>">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">email </h4>
              <input type="email" name='info-email' class="input-text input-email" value="<?= $email ?>">
            </div>
            <p class="validation-message"></p>
          </div>

        </div>
      </div>

      <div class="overlay-info-button-wrap">
        <input type="submit" value="Save" name="<?php echo isset($addNew) ? 'add-submit' : 'edit-submit' ?>"></input>
        <a href="index.php" class="overlay-info-button-wrap-btn">close</a>
      </div>

    </form>
  </div>
  </div>
  <?php
  } elseif (isset($_GET['addNew'])) {
    echo "<div class='overlay active'>";
  ?>
  <div class="overlay-new">
    <div class="overlay-info-heading">
      <h2 class="h2-heading">New</h2>
    </div>
    <form action="<?php echo isset($_GET['addNew']) ? './handle/newAccount.php' : './handle/edit.php' ?>" method="post"
      id="form">
      <div class="overlay-info-content">
        <div class="overlay-info-content-left">

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">account number</h4>
              <input type='text' name='info-account_number' value='<?= isset($account_number) ?>' disabled>
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">full name</h4>
              <input type='text' name='info-full_name' value='<?= isset($fullName) ?>'
                class="input-text input-full_name">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading"> balance </h4>
              <input type='number' min="0" name='info-balance' value='<?= isset($balance) ?>'
                class="input-text input-balance">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">age </h4>
              <input type="number" name='info-age' class="input-text input-age" value="<?= isset($age) ?>" min="18"
                max="100" step="1">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="overlay-info-content-wrap overlay-info-content-wrap-gender">
            <h4 class="h4-heading">gender </h4>
            <div class='overlay-info-content-wrap-radio'>
              <input type='radio' name='info-gender' id='info-gender-m' value='M' checked>
              <label for='info-gender-m'>Male</label>
            </div>
            <div class='overlay-info-content-wrap-radio'>
              <input type='radio' name='info-gender' id='info-gender-f' value='F'>
              <label for='info-gender-f'>Female</label>
            </div>
          </div>
        </div>
        <div class="overlay-info-content-right">

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">address </h4>
              <input type="text" name='info-address' class="input-text input-address" value="<?= isset($address) ?>">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">city </h4>
              <input type="text" name='info-city' class="input-text input-city" value="<?= isset($city) ?>">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="overlay-info-content-wrap">
            <h4 class="h4-heading">state </h4>
            <!-- <input type="state" name='info-state' class="" value="<?= isset($state) ?>"> -->
            <select name="info-state" id="" class="select">
              <?php
    $sql = 'SELECT * FROM state';
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      if ($row['state'] == $state) {
        echo "<option selected value  = '" . $row['state'] . "'>" . $row['name'] . "</option>";
      } else {
        echo "<option value  = '" . $row['state'] . "'>" . $row['name'] . "</option>";
      }
    }
              ?>
            </select>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">employer </h4>
              <input type="text" name='info-employer' class="input-text input-employer" value="<?= isset($employer) ?>">
            </div>
            <p class="validation-message"></p>
          </div>

          <div class="form-group">
            <div class="overlay-info-content-wrap">
              <h4 class="h4-heading">email </h4>
              <input type="email" name='info-email' class="input-text input-email"
                value="<?= isset($_POST['info-email']) ?>">
            </div>
            <p class="validation-message"></p>
          </div>

        </div>
      </div>

      <div class="overlay-info-button-wrap">
        <input type="submit" value="Save"
          name="<?php echo isset($_GET['addNew']) ? 'add-submit' : 'edit-submit' ?>"></input>
        <a href="index.php" class="overlay-info-button-wrap-btn">close</a>
      </div>

    </form>
  </div>
  </div>
  </div>
  <?php
  } ?>
  <script src="./assets/js/main.js"></script>
  <script src="./assets/js/search.js"></script>
  <script src="https://kit.fontawesome.com/49dffc725c.js" crossorigin="anonymous"></script>
  <script src="./assets/js/validate.js"></script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    Validator({
      form: '#form',
      formGroupSelector: '.form-group',
      errorSelector: ".validation-message",
      rules: [
        Validator.isRequired('.input-full_name', "Please enter full name"),
        Validator.isRequired('.input-balance', "Please enter balance"),
        Validator.isNumber('.input-balance', "Please enter balance"),
        Validator.maxLength('.input-balance', 10, 'Please enter 10 number'),
        Validator.isRequired('.input-age', 'Please enter age'),
        Validator.isNumber('.input-age', 'Please enter age'),
        Validator.isRequired('.input-address', 'Please enter address'),
        Validator.isRequired('.input-city', 'Please enter city'),
        Validator.isRequired('.input-employer', 'Please enter employer'),
        Validator.isRequired('.input-email', 'Please enter email'),
        Validator.isEmail('.input-email', 'Please enter your mail correctly'),

      ],
    })
  })
  </script>
</body>

</html>