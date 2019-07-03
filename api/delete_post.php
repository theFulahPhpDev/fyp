<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once 'config/Database.php';
  include_once 'models/question.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantiate blog question object
  $question = new Question($db);

  // Get raw questioned data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $question->id = $data->id;
    $id = $question->id;
  // Delete question
  if($question->delete($id)) {
    echo json_encode(
      array('message' => 'Question Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Question Not Deleted')
    );
  }

