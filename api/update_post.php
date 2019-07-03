<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once 'config/Database.php';
  include_once 'models/question.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog question object
  $question = new Question($db);

  // Get raw questioned data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $question->id = $data->id;
  $id = $question->id;
  $question->body = $data->body;
  $question->author = $data->author;
  $question->category_id = $data->category_id;

  // Update question
  if($question->update($id)) {
    echo json_encode(
      array('message' => 'question Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'question Not Updated')
    );
  }

