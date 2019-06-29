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
        <?php
            session_start();
            if(isset($_SESSION['username'])){ 
                ?>
                <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                    <a class="navbar-brand" href="index.php">Zawaj Doctors</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav ml-auto">
                        <a class="nav-item nav-link" href="index.php" id='home'>Home</a>
                        <a class="nav-item nav-link" href="logout.php">Logout</a>
                        <a class="nav-item nav-link" href="account.php" id="update_account">Account</a>
                        
                        </div>
                    </div>
                </nav>
                <div class="row">
                    <div class="col">
                        <!-- where prompt / messages will appear -->
                        <div id="response">
                        </div>
                        <h5>Click the button to update your account details</h5>
                        <p><button id="showForm">Show</button></p>
                        <h5>Click this button to delete your account</h5>
                        <p><button id="deleteAccount">Show</button></p>
                        <!-- where main content will appear -->
                        <div id="content">
                            
                        </div>
                    </div>
                </div>
                <?php
            }
            else {
                
                echo "
                        <h5 class=\"card-title\">You must login to see the account page</h5>
                        <p class=\"card-text\">Please register or login <a href=\"register.php\">here</a></p>
                    ";
                
            }
    
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
        // trigger when 'update account' form is submitted
        $(document).on("click","#showForm",function() {
                $.ajax({
                    type: "GET",
                    url: 'api/read_user.php',
                    dataType: 'json', 
                    success: function (response) {

                        var html = `
                            <h2>Update Account</h2>
                            <form id='update_account_form'>
                                <a href="upload.php"><img height="50px" width="50px" src="` + response.profile_pic + `"></a>
                                
                                <div class="form-group">
                                    <label for="firstname">Firstname</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" required value="` + response.firstname + `" />
                                </div>

                                <div class="form-group">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" required value="` + response.lastname + `" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" required value="` + response.username + `" />
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required value="` + response.email+ `" />
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" />
                                </div>
                                <input  id="user_id" value="` + response.id + `">
                                <button type='submit' class='btn btn-primary'>
                                    Save Changes
                                </button>
                            </form>
                            `;
                        
                            $('#content').html(html);
                    }
                });
            });

            $(document).on('submit', '#update_account_form', function(){          
                
                var update_account_form=$(this);          
                var form_data=JSON.stringify(update_account_form.serializeObject());  
                var file = $('#profile_pic')[0].files[0];
                // submit form data to api
                $.ajax({
                    url: "api/update_user.php",
                    type : "POST",
                    contentType : 'application/json',
                    data : form_data,
                    success : function(result) {
                        
                        // tell the user account was updated
                        $('#response').html("<div class='alert alert-success'>Account was updated.</div>");
                
                    },
                
                    // show error message to user
                    error: function(xhr, resp, text){
                        
                            $('#response').html("<div class='alert alert-danger'>Unable to update account.</div>");
                        
                    }
                });

                return false;
            });
             
            $(document).on("click","#deleteAccount",function() {
                var r = confirm("Do you really want to delete your account?");
                if(r){
                    $.ajax({
                        type: "DELETE",
                        url: 'api/delete_user.php',
                        dataType: 'json', 
                        success: function (response) {                            
                                window.location.href = "logout.php";
                        }
                    });
                }
            });

            // function to make form values to json format
            $.fn.serializeObject = function(){
                var o = {};
                var a = this.serializeArray();
                $.each(a, function() {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };
    </script>

    </body>
</html>
    

        

                    

                