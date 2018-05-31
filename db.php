<?php

class Database {

  private $connection;

  private function connection() {
    if (!$this->connection) {
      $this->connection = mysqli_connect($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASS'], $GLOBALS['DB_NAME']);
      if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
      }
    }
    return $this->connection;
  }

  private function query($sql) {
    echo "Running SQL:\n{$sql}\n";
    $res = mysqli_query($this->connection(), $sql);
    if (!$res) {
      $error = mysqli_error($this->connection());
      die("Error running SQL:\n{$sql}\n{$error}\n\n");
    }
    return $res;
  }

  private function parse_where($where) {
    $parsed = '';
    foreach ($where as $field => $value) {
        $parsed .= '`' . $field . '` = \'' . $value . "' AND ";
    }
    $parsed = rtrim($parsed, ' AND ');
    return $parsed;
  }

  public function insert_id() {
    return mysqli_insert_id($this->connection());
  }

  public function escape($str) {
    return mysqli_real_escape_string($this->connection(), $str);
  }

  public function insert($table, $cols) {
    $cols_list = '`' . implode('`,`', array_keys($cols)) . '`';
    $vals = '\'' . implode('\',\'', $cols) . '\'';
    $this->query("INSERT INTO `{$table}` ({$cols_list}) VALUES ({$vals})");
  }

  public function update($table, $cols, $where) {
    $updates = '';
    foreach ($cols as $field => $value) {
      $updates .= "`{$field}` = '$value',";
    }
    $updates = rtrim($updates, ',');
    $this->query("UPDATE `{$table}` SET {$updates} WHERE {$where}");
  }

  public function has($table, $where) {
    $res = $this->query("SELECT * FROM `{$table}` WHERE {$where}");
    var_dump($res->num_rows > 0);
    return ($res->num_rows > 0);
  }

  public function insert_or_update($table, $cols, $where) {
    $where = $this->parse_where($where);
    if ($this->has($table, $where)) {
      $this->update($table, $cols, $where);
    } else {
      $this->insert($table, $cols);
    }
  }
}
