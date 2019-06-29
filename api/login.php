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
    
    // instantiate user object
    $user = new User($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // set product property values
    $user->email = $data->email;
    
    $email_exists = $user->check_email_exists();
    
    
    // check if email exists and if password is correct
    if($email_exists && password_verify($data->password, $user->password)){
        
        $_SESSION['username'] = $user->username;
        $_SESSION['id'] = $user->id;
        // set response code
        http_response_code(200);
        // tell the user login was successful
        echo json_encode(
                array(
                    "message" => "Successful login.",
                    "Username" => $_SESSION['username'],
                    "User ID" => $_SESSION['id']
                )
            );
    
    }
    
    // login failed
    else{
    
        // set response code
        http_response_code(401);
    
        // tell the user login failed
        echo json_encode(array("message" => "Login failed."));
    }
?>