<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require_once '../../config/Database.php';
  require_once '../../models/Column.php';

  // query by board id
  if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['board_id'])) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
    
    // Instantiate column object
    $column = new Column($db);
    // Get columns
    $result = $column->read_by_board_id($_GET['board_id']);
    // Get row count
    $num = $result->rowCount();
    // Check if any columns
    if ($num > 0) {
      // Column array
      $columns_arr = array();
      $columns_arr['data'] = array();
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $column_item = array(
          'id' => $id,
          'name' => $name,
          'board_id' => $board_id
        );
        // Push to "data"
        array_push($columns_arr['data'], $column_item);
      }
      // Turn to JSON & output
      echo json_encode($columns_arr);
    } else {
      // No columns
      echo json_encode(
        array('message' => 'No columns found')
      );
    }

    return;
  }

  // request == get
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
    
    // Instantiate column object
    $column = new Column($db);
    // Get columns
    $result = $column->read();
    // Get row count
    $num = $result->rowCount();
    // Check if any columns
    if ($num > 0) {
      // Column array
      $columns_arr = array();
      $columns_arr['data'] = array();
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $column_item = array(
          'id' => $id,
          'name' => $name,
          'board_id' => $board_id
        );
        // Push to "data"
        array_push($columns_arr['data'], $column_item);
      }
      // Turn to JSON & output
      echo json_encode($columns_arr);
    } else {
      // No columns
      echo json_encode(
        array('message' => 'No columns found')
      );
    }
  }

  // post request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
    
    // Instantiate column object
    $column = new Column($db);
    // Get data
    $data = json_decode(file_get_contents('php://input'));
    // Set data
    $column->name = $data->name;
    $column->board_id = $data->board_id;
    // Create column
    if ($column->create()) {
      // Column created
      echo json_encode(
        array('message' => 'Column created')
      );
    } else {
      // Column not created
      echo json_encode(
        array('message' => 'Column not created')
      );
    }
  }

  // put request
  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
    
    // Instantiate column object
    $column = new Column($db);
    // Get data
    $data = json_decode(file_get_contents('php://input'));
    // Set data
    $column->id = $data->id;
    $column->name = $data->name;
    $column->board_id = $data->board_id;
    // Update column
    if ($column->update()) {
      // Column updated
      echo json_encode(
        array('message' => 'Column updated')
      );
    } else {
      // Column not updated
      echo json_encode(
        array('message' => 'Column not updated')
      );
    }
  }

  // delete request
  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
    
    // Instantiate column object
    $column = new Column($db);
    // Get data
    $data = json_decode(file_get_contents('php://input'));
    // Set data
    $column->id = $data->id;
    // Delete column
    if ($column->delete()) {
      // Column deleted
      echo json_encode(
        array('message' => 'Column deleted')
      );
    } else {
      // Column not deleted
      echo json_encode(
        array('message' => 'Column not deleted')
      );
    }
  }
?>