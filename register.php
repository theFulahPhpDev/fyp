<?php 
    session_start();
    if(isset($_SESSION['username']))
        $username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Register</title>   
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css" />
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
                        <a class="nav-item nav-link" href="account.php" id="update_account">Account</a>
                        <a class="nav-item nav-link" href="#" id='logout'>Logout</a>
                        <a class="nav-item nav-link" href="register.php" id="signedUp">Login or Register</a>
                    </div>
                </div>
        </nav>
        
        <main role="main" class="container starter-template">
            <div class="row">
                <div class="col">
                    <!-- where prompt / messages will appear -->
                    <div id="response">
                    </div>
                    <!-- where main content will appear -->
                    <div id="content">
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col" id="form1">
                    <h2>Sign Up</h2>
                    <form id='sign_up_form'>
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" required />
                        </div>
            
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required />
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                            <label class="form-check-label" for="male">
                                Man
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="female">
                                Woman
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required />
                        </div>
            
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required />
                        </div>
            
                        <button type='submit' class='btn btn-primary'>Sign Up</button>
                        <small class="form-text text-muted">You already have an account? Please <a href="#" id="login" >sign in</a></small>
                    </form>
                </div>
            </div>      
        </main>
        

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            
                //console.log('Page ready');
                //clearResponse();
                
                // trigger when registration form is submitted
                $(document).on('submit', '#sign_up_form', function(e){  
                    e.preventDefault(); 
                    // get form data    
                    var sign_up_form=$(this);          
                    var form_data=JSON.stringify(sign_up_form.serializeObject());       
                    // submit form data to api
                    $.ajax({
                        url: "api/create_user.php",
                        type : "POST",
                        dataType: "json",
                        contentType : 'application/json;charset=utf-8',
                        data : form_data,
                        success : function(result) {   
                            $('#response').html("<div class='alert alert-success'>Successful sign up. Please login.</div>");
                            sign_up_form.find('input').val('');
                        },
                        error: function(xhr, resp, text){
                            // on error, tell the user sign up failed
                            $('#response').html("<div class='alert alert-danger'>Unable to sign up. Please contact admin.<br>Username or Email already taken</div>");           
                        }
                    });
                    return false;
                    
                });
                // trigger when login form is submitted
                $(document).on('submit', '#login_form', function(e){
                    e.preventDefault(); 
                    // get form data
                    var login_form=$(this);
                    var form_data=JSON.stringify(login_form.serializeObject());
                    // submit form data to api
                    $.ajax({
                        url: "api/login.php",
                        type : "POST",
                        contentType : 'application/json',
                        data : form_data,
                        success : function(result){
                            
                            // show home page & tell the user it was a successful login
                            showHomePage();
                            $('#response').html("<div class='alert alert-success'>Successful login.</div>");
                        },
                        error: function(xhr, resp, text){
                            // on error, tell the user login has failed & empty the input boxes
                            $('#response').html("<div class='alert alert-danger'>Login failed. Email or password is incorrect.</div>");
                            login_form.find('input').val('');
                        }
                    });
                    return false;
                });
                
                // remove any prompt messages
                function clearResponse(){
                    $('#response').html('');
                }
                // show login form
                $(document).on('click', '#login', function(){
                    hideSignUp();
                    showLoginPage();
                });
                $(document).on('click', '#sign_up', function(){
                    clearResponse();
                    showSignUp();
                });
                // show home page function definition
                function showHomePage(){  
                    
                        // if valid, show homepage
                       var html = `
                            <div class="card">
                                <div class="card-header">Welcome to Home!</div>
                                <div class="card-body">
                                    <h5 class="card-title">You are logged in.</h5>
                                    <p class="card-text">Now you can post questions and comment!</p>
                                </div>
                            </div>
                            `;
                        
                        $('#content').html(html);
                    
                        showLoggedInMenu();
            
                }

                // show login page
                function showLoginPage(){
                    hideSignUp();
                    

                    // login page html
                    var html = `
                        <div class="col" id="form2">
                            <h2>Login</h2>
                            <form id='login_form'>
                                <div class='form-group'>
                                    <label for='email'>Email address</label>
                                    <input type='email' class='form-control' id='email' name='email' placeholder='Enter email'>
                                </div>

                                <div class='form-group'>
                                    <label for='password'>Password</label>
                                    <input type='password' class='form-control' id='password' name='password' placeholder='Password'>
                                </div>

                                <button type='submit' class='btn btn-primary'>Login</button>
                                <small class="form-text text-muted"><small class="form-text text-muted">No account?Create one <a href="#" id='sign_up'>here</a></small></small>
                            </form>
                        </div>
                        `;

                    $('#content').html(html);
                    clearResponse();
                    showLoggedOutMenu();
                }
                
                 

                // if the user is logged in
                function showLoggedInMenu(){
                    // hide login and sign up from navbar & show logout button
                    $("#signedUp").hide();
                    $("#logout").show();
                }
                
                // logout the user
                $(document).on('click', '#logout', function(){
                    showLoginPage();
                    showLoggedOutMenu();
                    //$('#response').html("<div class='alert alert-info'>You are logged out.</div>");
                    window.location.href = "logout.php"
                });
                
                // if the user is logged out
                function showLoggedOutMenu(){
                    // show login and sign up from navbar & hide logout button
                    $("#login, #sign_up").show();
                    $("#logout").hide();
                }
                function hideSignUp(){
                    $("#form1").hide();
                }
                function showSignUp(){
                    $("#form2").hide();
                    $("#form1").show();
                }
                
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