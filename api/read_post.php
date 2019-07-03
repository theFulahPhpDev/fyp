<?php 
    //session_start();
  // Headers
  header('Access-Control-Allow-Origin: http://localhost:8000/zawaj_doctors/');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  include_once 'config/Database.php';
  include_once 'models/Question.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantiate blog question object
  $question = new Question($db);
  $question_id = $_GET['q'];
  // Get ID
  $question->id  = $question_id;
  
  // Get question
  $question->read_single();

  // Create array
  $question_arr = array(
    'id' => $question->id,
    'body' => $question->body,
    'author' => $question->author,
    'category_name' => $question->category_name,
    'post_date' => $question->post_date,
    'post_time' => $question->post_time
  );
  
  if($question->read_single()){
      // Make JSON
      
      echo json_encode($question_arr);
  } else {
    // show error message
    echo json_encode(array("message" => "Unable to show question"));
  }
  