<?php

class Connection {
  public function getConnection() {
    $host = 'localhost';
    $user = 'root';
    $password = 'root123';
    $database = 'angular_blog';

    $conn = new mysqli($host, $user, $password, $database) or die($conn->error . __LINE__);
    return $conn;
  }
}

class Database {

  private $conn = NULL;

  public __construct() {
    $connection = new Connection();
    $this->conn = $connection->getConnection();
  }

  public function authenticate_user($username, $password) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'";
    $result = $this->conn->query($query);

    if($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $this->set_session($row);

      $response['username'] = $row['username'];
      $response['uid'] = $row['uid'];
    }
    else {
      $response['username'] = '';
      $response['uid'] = '';
    }

    return $response;
  }

  public function set_session ($data = '') {
    if(!isset($_SESSION)) {
      session_start();
    }

    if(!empty($data)) {
      $_SESSION['username'] = $data['username'];
      $_SESSION['uid'] = $data['uid'];
    }
  }
}