<?php 
    session_start();
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once 'config/Database.php';
    include_once 'models/Reply.php';
    

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->getConnection();

    // Instantiate reply object
    $reply = new reply($db);
    
    // Get raw replyed data
    $data = json_decode(file_get_contents("php://input"));
    
    // Get Username
    $reply->author = isset($_SESSION['username']) ? $_SESSION['username'] : die();
    $reply->content = $data->content;
    $reply->answer_id = $data->answer_id;

    
    // Create reply
    if(
        
        $reply->create()
      ) {
      echo json_encode(
        array('message' => 'reply has been added')
      );
      
    } else {
      echo json_encode(
        array('message' => 'reply not added')
      );
    }

