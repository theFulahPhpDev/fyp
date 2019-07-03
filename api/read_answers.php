<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  include_once 'config/Database.php';
  include_once 'models/Answer.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantiate answer object
  $answer = new Answer($db);

  $question_id = $_GET['q'];
  // Get ID
  $answer->question_id  = $question_id;

  // answer post query
  $result = $answer->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $answers_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $answer_item = array(
        'id' => $id,
        'content' => $content,
        'author' => $author,
        'post_date' => $post_date,
        'post_time' => $post_time
      );

      // Push to "data"
      array_push($answers_arr, $answer_item);
      
    }

    // Turn to JSON & output
    echo json_encode($answers_arr);

  } else {
    // No answers
    echo json_encode(
      array('message' => 'No answers Found')
    );
  }
