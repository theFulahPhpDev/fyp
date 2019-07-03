<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  include_once 'config/Database.php';
  include_once 'models/Reply.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantiate reply object
  $reply = new Reply($db);

  $answer_id = $_GET['q'];
  // Get ID
  $reply->answer_id  = $answer_id;

  // reply post query
  $result = $reply->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $replies_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $reply_item = array(
        'id' => $id,
        'content' => $content,
        'author' => $author,
        'post_date' => $post_date,
        'post_time' => $post_time
      );

      // Push to "data"
      array_push($replies_arr, $reply_item);
      
    }

    // Turn to JSON & output
    echo json_encode($replys_arr);

  } else {
    // No replys
    echo json_encode(
      array('message' => 'No replies Found')
    );
  }
