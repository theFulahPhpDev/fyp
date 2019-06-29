<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Zawaj Doctors API</title>   
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <?php
            session_start();
            if(isset($_SESSION['username'])){ 
                ?>
        <form id="uploadForm" action="process_upload.php" method="post" enctype="multipart/form-data">
            <input id="profile_pic" type="file" accept="image/*" name="profile_pic" />
            
            <input class="btn btn-success" type="submit" value="Upload">
            <br><a href="account.php">Go back to account page</a>
        </form>
        <?php
            }
            else {
                
                echo "
                        <h5 class=\"card-title\">You must login to see the accounts page</h5>
                        <p class=\"card-text\">Please register or login <a href=\"register.php\">here</a></p>
                    ";
                
            }
    
        ?>
                
            
        
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
    </body>
    
</html>


