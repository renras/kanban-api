<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require_once '../../config/Database.php';
  require_once '../../models/Board.php';

  // request == get
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate board object
    $board = new Board($db);
    // Get boards
    $result = $board->read();
    // Get row count
    $num = $result->rowCount();
    // Check if any boards
    if ($num > 0) {
      // Board array
      $boards_arr = array();
      $boards_arr['data'] = array();
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $board_item = array(
          'id' => $id,
          'name' => $name
        );
        // Push to "data"
        array_push($boards_arr['data'], $board_item);
      }
      // Turn to JSON & output
      echo json_encode($boards_arr);
    } else {
      // No boards
      echo json_encode(
        array('message' => 'No boards found')
      );
    }
  } 

  // post request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate board object
    $board = new Board($db);
    // Get data
    $data = json_decode(file_get_contents('php://input'));
    // Set data
    $board->name = $data->name;
    // Create board
    if ($board->create()) {
      // Board created
      echo json_encode(
        array('message' => 'Board created')
      );
    } else {
      // Board not created
      echo json_encode(
        array('message' => 'Board not created')
      );
    }
  } 

  // put request
  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate board object
    $board = new Board($db);
    // Get data
    $data = json_decode(file_get_contents('php://input'));
    // Set data
    $board->id = $data->id;
    $board->name = $data->name;
    // Update board
    if ($board->update()) {
      // Board updated
      echo json_encode(
        array('message' => 'Board updated')
      );
    } else {
      // Board not updated
      echo json_encode(
        array('message' => 'Board not updated')
      );
    }
  } 

  // delete request
  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate board object
    $board = new Board($db);
    // Get data
    $data = json_decode(file_get_contents('php://input'));
    // Set data
    $board->id = $data->id;
    // Delete board
    if ($board->delete()) {
      // Board deleted
      echo json_encode(
        array('message' => 'Board deleted')
      );
    } else {
      // Board not deleted
      echo json_encode(
        array('message' => 'Board not deleted')
      );
    }
  } 
?>