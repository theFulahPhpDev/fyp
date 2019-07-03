<?php 
    session_start();
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once 'config/Database.php';
    include_once 'models/Question.php';
    include_once 'models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->getConnection();

    // Instantiate question object
    $question = new Question($db);

    // Instantiate user object
    $user = new User($db);

    // Get raw questioned data
    $data = json_decode(file_get_contents("php://input"));

    // Get Username
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : die();

    $question->body = $data->body;
    $question->author = $username;
    $question->category_name = $data->category_name;

    //Add points for user
    $user->addPoints(30,$username);
    $user->update_badge($username);
    

    // Create question
    if(
      //!empty($question->body) &&
      //!empty($question->category_name) &&
        $question->create($username)
      ) {
      echo json_encode(
        array('message' => 'Question has been created')
      );
    } else {
      echo json_encode(
        array('message' => 'Question not created')
      );
    }

