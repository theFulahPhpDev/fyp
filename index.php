<?php 
    session_start();
    if(isset($_SESSION['username']))
        $username = $_SESSION['username'];
?>
<!doctype html>
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
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                <a class="navbar-brand" href="index.php">Zawaj Doctors</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ml-auto">
                        <a class="nav-item nav-link" href="index.php" id='home'>Home</a>
                        <a class="nav-item nav-link" href="register.php" id='update_account'>Account</a>
                        <a class="nav-item nav-link" href="register.php">Login or Register</a>
                    </div>
                </div>
        </nav>
        <main role="main" class="container starter-template">
            <div class="row">
                <div class="col">
                <button type="button" data-toggle="modal" class="action ask-question">
                    <i class="fa fa-plus"></i> ASK A QUESTION                    
                </button>
                </div>
                <div class="col">
                    Welcome <?php echo $username ; ?>
                </div>
                <div class="col">

                </div>
            </div>
        </main>
    </body>
</html>
    
    
