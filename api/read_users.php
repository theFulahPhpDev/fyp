<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  include_once 'config/Database.php';
  include_once 'models/User.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->getConnection();

  // Instantiate user object
  $user = new User($db);

  // user post query
  $result = $user->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any users
  if($num > 0) {
    // Post array
    $users_arr = array();
    

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $user_item = array(
        'id' => $id,
        'username' => $username,
        'points' => $points,
        'profile_pic' => $profile_pic,
        'badge' => $badge
      );

      // Push to "data"
      array_push($users_arr, $user_item);
      
    }

    // Turn to JSON & output
    echo json_encode($users_arr);

  } else {
    // No users
    echo json_encode(
      array('message' => 'No users Found')
    );
  }
