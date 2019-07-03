<?php 
    session_start();
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once 'config/Database.php';
    include_once 'models/Answer.php';
    

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->getConnection();

    // Instantiate answer object
    $answer = new Answer($db);
    
    // Get raw answered data
    $data = json_decode(file_get_contents("php://input"));
    
    // Get Username
    $answer->author = isset($_SESSION['username']) ? $_SESSION['username'] : die();
    $answer->content = $data->content;
    $answer->question_id = $data->question_id;

    
    // Create answer
    if(
        
        $answer->create()
      ) {
      echo json_encode(
        array('message' => 'Answer has been added')
      );
      
    } else {
      echo json_encode(
        array('message' => 'Answer not added')
      );
    }

