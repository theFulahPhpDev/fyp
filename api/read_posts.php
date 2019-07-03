<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  include_once 'config/Database.php';
  include_once 'models/Question.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantiate question object
  $question = new Question($db);

  // Question post query
  $result = $question->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $questions_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $question_item = array(
        'id' => $id,
        'body' => $body,
        'author' => $author,
        'category_name' => $category_name,
        'post_date' => $post_date,
        'post_time' => $post_time
      );

      // Push to "data"
      array_push($questions_arr, $question_item);
      
    }

    // Turn to JSON & output
    echo json_encode($questions_arr);

  } else {
    // No Questions
    echo json_encode(
      array('message' => 'No Questions Found')
    );
  }
