<?php

class Database {

  private $connection;

  private function connection() {
    if (!$this->connection) {
      $this->connection = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
      if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
      }
    }
    return $this->connection;
  }

  private function query($sql) {
    $res = mysqli_query($this->connection(), $sql);
    if (!$res) {
      $error = mysqli_error($this->connection());
      die("");
    }
    return $res;
  }

  public function escape($str) {
    return mysqli_real_escape_string($this->connection, $str);
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
    $this->query("UPDATE {$table} SET {$updates} WHERE {$where}");
  }

  public function has($table, $where) {
    $res = $this->query("SELECT * FROM `{$table}` WHERE `{$where}'");
    return ($res->num_rows > 0);
  }

  public function insert_or_update($table, $cols, $where) {
    $where = '`' . key($where) . '` = \'' . current($where) . "'";
    if ($db->has($table, $where)) {
      $db->update($table, $cols, $where);
    } else {
      $db->insert($table, $cols);
    }
  }
}
