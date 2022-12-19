<?php
class Database
{
  private $__host = 'sqlite';
  // private $__db_name = 'bank';
  // private $__username = 'root';
  // private $__password = '';
  function connect()
  {
    $connect = null;
    try {
      if (file_exists('bank.db')) {
        $connect = new PDO(
          "sqlite:bank.db",
          "",
          ""
        );
      } else {
        $connect = new PDO(
          "sqlite:../bank.db",
          "",
          ""
        );
      }
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $connect;
    } catch (PDOException $e) {
      echo "<h1>Connection failed " . $e->getMessage() . "</h1>";
      $connect = null;
      exit;
    }
  }
}
class Data extends Database
{
  private $__start, $__rowPerPage, $__totalPages;
  private $_data = '';
  public $strPage = "";
  public $permissions = array();

  function getPermissions()
  {
    $this->permissions = $_SESSION['permissions'];
  }

  function read($sql)
  {
    $connect = $this->connect();
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  function getMax($column, $table, $where = '')
  {
    $connect = $this->connect();

    $sql = "select max($column) from $table $where";
    $statement = $connect->prepare($sql);
    $statement->execute();
    // echo $sql;
    return $statement->fetchColumn() + 1;
  }

  function getID($column, $table, $where = '')
  {
    $connect = $this->connect();

    $sql = "select $column from $table $where limit 1";
    $statement = $connect->prepare($sql);
    $statement->execute();
    return $statement->fetch()[0];
  }

  function Navigation($total)
  {
    $rowPerPage = 15;
    $_SESSION['pages'] = $pages = $total / $rowPerPage;
    $_SESSION['start'] = 0;
    $index = 1;
    for ($index; $index <= $pages; $index++) {
      $this->strPage .= "<li>
      <a href = './?page=$index' class='content-navigation-link'> $index </a>
      </li>";
    }

    // $strPage .= "<a href = './?page=$index' class='content-navigation-link navigation-pre-next'> <i class='fa-solid fa-play'></i> </a>";

    $currentPage = 1;
    if (isset($_GET['page'])) {
      $currentPage = $_GET['page'];
      $_SESSION['start'] = ($currentPage - 1) * $rowPerPage;
    }
    $_SESSION['currentPage'] = $currentPage;
  }

  function countTotal($table)
  {
    global $connect;
    $this->connect();
    $sql = "select count(*) as total from $table ";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $total = $statement->fetch()['total'];
    return $total;
  }
  function query($sql)
  {
    $connect = $this->connect();
    $statement = $connect->prepare($sql);
    $result = $statement->execute();
    return $result;
  }
}
?>