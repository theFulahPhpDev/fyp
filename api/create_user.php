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
    include_once 'models/User.php';
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // instantiate product object
    $user = new User($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // set product property values
    $user->firstname = $data->firstname;
    $user->lastname = $data->lastname;
    $user->username = $data->username;
    $user->gender = $data->gender;
    $user->email = $data->email;
    $email_exists = $user->check_email_exists();
    $username_exists = $user->check_username_exists();
    $user->password = $data->password;

    
    // create the user
    if(
        !empty($user->firstname) &&
        !empty($user->gender) &&
        !empty($user->email) &&
        !empty($user->username) &&
        !$email_exists &&
        !$username_exists &&
        !empty($user->password) &&
        $user->create()
    ){
        $username = $user->username;
        $_SESSION['username'] = $username;
        // set response code
        http_response_code(200);
        
        // display message: user was created
        echo json_encode(array("message" => "User was created.",
    "details" => $_SESSION['username']));
    }
    
    // message if unable to create user
    else{
    
        // set response code
        http_response_code(400);
    
        // display message: unable to create user
        echo json_encode(array("message" => "Unable to create user."));
    }
?>
