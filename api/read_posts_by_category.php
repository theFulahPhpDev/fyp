<?php 
    session_start();
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once 'config/Database.php';
  include_once 'models/Question.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantiate blog question object
  $question = new Question($db);

  // Get ID
  $id = isset($_SESSION['id']) ? $_SESSION['id'] : die();

  // Get question
  $question->read_single($id);

  // Create array
  $question_arr = array(
    'id' => $question->id,
    'body' => $question->body,
    'author' => $question->author,
    'category_id' => $question->category_id,
    'category_name' => $question->category_name
  );
  if($question->read_single($id)){
      // Make JSON
        echo json_encode($question_arr);
  } else {
    // show error message
    echo json_encode(array("message" => "Unable to show question"));
  }
  