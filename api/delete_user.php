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
    include_once 'models/user.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Instantiate user object
    $user = new User($db);
    // Get ID
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : die();
    

    if($user->delete($id)){
        // Make JSON
        echo json_encode(array("message" => "User has been deleted"));
    }else {
        // show error message
        echo json_encode(array("message" => "User can't be deleted"));
    }
  
