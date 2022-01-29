<?php

require_once 'database.php';

class User {
    private $conn;

    // Constructor
    public function __construct(){
      $database = new Database();
      $db = $database->dbConnection();
      $this->conn = $db;
    }


    // Execute queries SQL
    public function runQuery($sql){
      $stmt = $this->conn->prepare($sql);
      return $stmt;
    }

    // Insert
    public function insert($name, $phone, $person, $datetime){
      try{
        $stmt = $this->conn->prepare("INSERT INTO crud_users (name, phone, person, datetime) VALUES(:name, :phone, :person, :datetime)");
        $stmt->bindparam(":name", $name);
        $stmt->bindparam(":phone", $phone);
        $stmt->bindparam(":person", $person);
        $stmt->bindparam(":datetime", $datetime);
        $stmt->execute();
        return $stmt;
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }

    public function search($name){
      try{
       //<! $stmt = $this->conn->prepare("SELECT * FROM crud_users  WHERE name LIKE '%name%'");!>
        $stmt = $this->conn->prepare("SELECT * FROM crud_users WHERE name = $name");
        $stmt->bindparam(":name", $name);
        $stmt->execute();
        $stmt->setFetchMode(PDO:: FETCH_OBJ);
        return $stmt;
      }catch(PDOException $e){
        echo $e->getMessage();
      }
  }
    // Update
    public function update($name, $phone, $person, $datetime, $id){
        try{
          $stmt = $this->conn->prepare("UPDATE crud_users SET name = :name, phone = :phone, person= :person, datetime= :datetime WHERE id = :id");
          $stmt->bindparam(":name", $name);
          $stmt->bindparam(":phone", $phone);
          $stmt->bindparam(":person", $person);
          $stmt->bindparam(":datetime", $datetime);
          $stmt->bindparam(":id", $id);
          $stmt->execute();
          return $stmt;
        }catch(PDOException $e){
          echo $e->getMessage();
        }
    }


    // Delete
    public function delete($id){
      try{
        $stmt = $this->conn->prepare("INSERT INTO deleted_crud_users (name, phone, person, datetime,Deleted_at) SELECT name, phone, person, datetime,current_timestamp() FROM crud_users d WHERE id = :id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        $stmt = $this->conn->prepare("DELETE FROM crud_users WHERE id = :id");
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return $stmt;
      }catch(PDOException $e){
          echo $e->getMessage();
      }
    }

    // Redirect URL method
    public function redirect($url){
      header("Location: $url");
    }
}
?>
