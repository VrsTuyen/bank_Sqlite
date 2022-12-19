<?php
session_start();

$limit = 15;
$page = 1;

include_once('./Data.php');
include_once('./function.php');

$data = new Data();
$connect = $data->connect();

$permissions = getPermissions($_SESSION['account'], $connect);


if (isset($_GET['page'])) {
  $page = (int) $_GET['page'];
  $start = (($page - 1) * $limit);
} else {
  $start = 0;
}

$sql = "
SELECT accounts.account_number,
balance,
first_name,
last_name,
age,
gender,
address,
city,
state.name as state,
employer,
email
FROM accounts INNER JOIN state on accounts.state = state.state
";
if (isset($_GET['data']) && $_GET['data'] != '' && $_GET['data'] != 'undefined') {
  $text = $_GET['data'];
  $sql .= "WHERE
  accounts.account_number LIKE '%$text%' OR
  accounts.balance LIKE '%$text%' OR
  accounts.first_name LIKE '%$text%' OR
  accounts.last_name LIKE '%$text%' OR
  accounts.age LIKE '%$text%' OR
  accounts.gender LIKE '%$text%' OR
  accounts.address LIKE '%$text%' OR
  accounts.email LIKE '%$text%' OR
  accounts.employer LIKE '%$text%' OR
  accounts.city LIKE '%$text%' OR
  state.name LIKE '%$text%' AND
  accounts.state = state.state ";
}

if (isset($_GET['order']) && !empty($_GET['order'])) {
  $sql .= " order by accounts." . $_GET['order'];
}

// $result = $data->read($sql);

$statement = $connect->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();
$total_data = count($result);

$sql .= " LIMIT $start, $limit ;";

$result = $data->read($sql);
$output = "
<div style = 'font-size: 1.6rem; margin-bottom: 4px; transform: translateY(-100%)'>Total Records: $total_data</div>
<table class='content-container-table'>
<thead>
  <th data-query = 'account_number' class = 'table-header'>account number</th>
  <th data-query = 'balance' class = 'table-header'>balance</th>
  <th data-query = 'first_name' class = 'table-header'>full name</th>
  <th data-query = 'age' class = 'table-header'>age</th>
  <th data-query = 'gender' class = 'table-header'>gender</th>
  <th data-query = 'address' class = 'table-header'>address</th>
  <th data-query = 'employer' class = 'table-header'>employer</th>
  <th data-query = 'email' class = 'table-header'>email</th>";
if (checkPermission($permissions, 'update-account' || checkPermission($permissions, 'delete-account'))) {
  $output .= "<th colspan='2'></th>";
}
$output .= "</thead>
<tbody class='content-container-table-body'>";

if ($total_data > 0) {
  foreach ($result as $row) {
    $output .= "
    <tr>
      <td>" . $row['account_number'] . "</td>
      <td>" . $row['balance'] . "</td>
      <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
      <td>" . $row['age'] . "</td>
      <td>" . gender($row['gender']) . "</td>
      <td>" . $row['address'] . ", " . $row['city'] . ", " . $row['state'] . "</td>
      <td>" . $row['employer'] . "</td>
      <td>" . $row['email'] . "</td>
     ";


    if (checkPermission($permissions, 'update-account')) {
      $output .= "<td><a class = 'link-icon' href = '?account_number=" . $row['account_number'] . "'><i class='fi fi-sr-eye'></i></a></td>";
    }
    if (checkPermission($permissions, 'delete-account')) {
      $output .= "<td><a href = './control/delete.php?page=" . $_GET['page'] . "&account_number=" . $row['account_number'] . "' onclick = 'return showMessageDelete(this)' class = 'link-icon'> <i class='red-color fa-solid fa-trash'></i></a></td>";
    }
    $output .= "</tr>";
  }
} else {
  $output .= '<tr><td colspan = "10" align = "center">No Data Found</td></tr>';
}

$output .= "   
</tbody>
</table>

<div class='pagination'>
<ul class='pagination-list'>
";

// phan trang
$total_link = ceil($total_data / $limit);
$previous_link = '';
$next_link = '';
$page_link = '';
$page_array = array();
if ($total_link > 4) {

  if ($page < 5) {

    for ($i = 1; $i <= 5; $i++) {
      $page_array[] = $i;
    }
    $page_array[] = '...';
    $page_array[] = $total_link;

  } else {

    $end_limit = $total_link - 5;

    if ($page > $end_limit) {

      $page_array[] = 1;
      $page_array[] = '...';

      for ($i = $end_limit; $i <= $total_link; $i++) {
        $page_array[] = $i;
      }

    } else {

      $page_array[] = 1;
      $page_array[] = '...';

      for ($i = $page - 1; $i <= $page + 1; $i++) {
        $page_array[] = $i;
      }

      $page_array[] = '...';
      $page_array[] = $total_link;

    }
  }
} else {
  for ($i = 1; $i <= $total_link; $i++) {
    $page_array[] = $i;
  }
}
if (!$total_data == 0) {

  for ($i = 0; $i < count($page_array); $i++) {
    if ($page == $page_array[$i]) {

      $page_link .= '
        <li class = "pagination-item active">
          <a class = "pagination-item-link disable">' . $page_array[$i] . '</a>
        </li>';

      $previous_id = $page_array[$i] - 1;
      if ($previous_id > 0) {

        $previous_link = '
          <li class = "pagination-item">
            <a class = "pagination-item-link" href ="javascript:void(0)"  data-page_number = "' . $previous_id . '">Previous</a>
          </li>';

      } else {

        $previous_link = '
          <li class = "pagination-item">
            <a class = "pagination-item-link disable" >Previous</a>
          </li>';
      }

      $next_id = $page_array[$i] + 1;
      if ($next_id > $total_link) {
        $next_link = '
          <li class = "pagination-item">
            <a class = "pagination-item-link disable" >Next</a>
          </li>';
      } else {
        $next_link = '
          <li class = "pagination-item">
            <a class = "pagination-item-link" href = "javascript:void(0)" data-page_number = "' . $next_id . '">Next</a>
          </li>';
      }
    } else {
      if ($page_array[$i] == '...') {
        $page_link .= '
        <li class = "pagination-item">
          <a class = "pagination-item-link disable">...</a>
        </li>';
      } else {
        $page_link .= '
          <li class = "pagination-item">
            <a class = "pagination-item-link" href = "javascript:void(0)" data-page_number = "' . $page_array[$i] . '">' . $page_array[$i] . '</a>
          </li>';
      }
    }
  }
}

$output .= "$previous_link $page_link $next_link";
$output .= '</ul>';
echo $output;



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