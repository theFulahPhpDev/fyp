<?php
    session_start();
    // required headers
    header("Access-Control-Allow-Origin: *");
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
    
    // instantiate user object
    $user = new User($db);
    
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : die();

    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    

    // set user property values
    $user->firstname = $data->firstname;
    $user->lastname = $data->lastname;
    $user->username = $data->username;
    $user->email = $data->email;
    $user->password = $data->password;
    
    
    
    // create the product
    if($user->update($id)){
        
        
        // set response code
        http_response_code(200);
        
        // response in json format
        echo json_encode(
                array(
                    "message" => "User was updated."
                )
            );
    }
    
    // message if unable to update user
    else{
        // set response code
        http_response_code(401);
    
        // show error message
        echo json_encode(array("message" => "Unable to update user."));
    }


        
    
?>