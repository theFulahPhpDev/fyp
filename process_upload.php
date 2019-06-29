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
                                echo "Photo Uploaded and saved!";
                            }
                            
                            
                                                        
                    }
            }
    }
    

