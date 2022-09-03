<?php
  class Column {
    // DB stuff
    private $conn;
    private $table = 'columns';

    // Post Properties
    public $id;
    public $name;
    public $board_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get columns
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Execute query
      $stmt->execute();
      return $stmt;
    }

    // Get single column
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

    // Create column
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET name = :name, board_id = :board_id';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->board_id = htmlspecialchars(strip_tags($this->board_id));
      // Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':board_id', $this->board_id);
      // Execute query
      if($stmt->execute()) {
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }

    // Update column
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

    // Delete column
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

    // read by board id
    public function read_by_board_id($board_id) {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' WHERE board_id = ?';
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Bind ID
      $stmt->bindParam(1, $board_id);
      // Execute query
      $stmt->execute();
      return $stmt;
    }
  }
?>