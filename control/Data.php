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