<?php
abstract class Model
{
  protected $dbh; // Database handler.
  protected $stmt; // Statement.

  public function __construct()
  {
    $this->dbh = new PDO('mysql:host='.DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
  }

  public function query($query)
  {
    $this->stmt = $this->dbh->prepare($query);
  }

  public function bind($param, $value, $type = null) // $type = null means it's default value.
  {
    if (is_null($type)) {
      switch (true) {
        // Checking what type of data is beeing passed and then setting equivalent "$type" depending on what type of data it is. Because if i.e. it's an integer we want to go in Database as an integer etc.
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
          break;
      }
    }
    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute()
  {
    $this->stmt->execute();
  }

  public function resultSet()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC); // Return all records.
  }

  public function lastInsertId()
  {
    return $this->dbh->lastInsertId();
  }

  public function single() {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC); // Return 1 record.
  }
}