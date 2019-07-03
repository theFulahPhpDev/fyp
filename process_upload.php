<?php  
    session_start();
    // files needed to connect to database
    include_once 'api/config/database.php';
    include_once 'api/models/user.php';
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : die();

    // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
    if (isset($_FILES['profile_pic']) AND $_FILES['profile_pic']['error'] == 0)
    {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['profile_pic']['size'] <= 1000000)
            {
                    // Testons si l'extension est autorisée
                    $infosfichier = pathinfo($_FILES['profile_pic']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    if (in_array($extension_upload, $extensions_autorisees))
                    {
                            $path = "assets/profile_pics/".basename($_FILES['profile_pic']['name']);
                            // On peut valider le fichier et le stocker définitivement
                            if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], 'assets/profile_pics/' . basename($_FILES['profile_pic']['name']))){
                                $user->upload_pic($id,$path);
                                echo '<div style="text-align:center;"><h5 class="card-title">Photo Uploaded and saved!</h5><p class="card-text">Click <a href="account.php">here</a> back to your account page</p><div>';
                            }
                            
                            
                                                        
                    }
            }
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Upload Picture</title>   
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
