<?php 
    session_start();
    // required headers
    header("Access-Control-Allow-Origin: http://localhost:8000/zawaj_doctors/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // files needed to connect to database
    include_once 'config/database.php';
    include_once 'models/Answer.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Instantiate answer object
    $answer = new Answer($db);

    $data = json_decode(file_get_contents("php://input"));

    // Get ID
    $answer->id = $data->answer_id;
    

    if($answer->update_votes()){
        // Make JSON
        echo json_encode(array("message" => "Answer has been updated"));
    }else {
        // show error message
        echo json_encode(array("message" => "Answer not updated"));
    }
  
