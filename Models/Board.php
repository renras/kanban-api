<?php
  class Board {
    // DB stuff
    private $conn;
    private $table = 'boards';

    // Post Properties
    public $id;
    public $name;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get boards
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Execute query
      $stmt->execute();
      return $stmt;
    }

    // Get single board
    public function read_single() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Bind ID
      $stmt->bindParam(1, $this->id);
      // Execute query
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      // Set properties
      $this->name = $row['name'];
    }

    // Create board
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET name = :name';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      // Bind data
      $stmt->bindParam(':name', $this->name);
      // Execute query
      if($stmt->execute()) {
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }

    // Update board
    public function update() {
      // Create query
      $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->id = htmlspecialchars(strip_tags($this->id));
      // Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':id', $this->id);
      // Execute query
      if($stmt->execute()) {
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }

    // Delete board
    public function delete() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      // Bind data
      $stmt->bindParam(':id', $this->id);
      // Execute query
      if($stmt->execute()) {
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }
  }
?>