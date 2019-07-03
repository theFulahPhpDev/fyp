<?php 
    session_start();
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
                <a class="navbar-brand" href="index.php" style="font-family:FF Avance;">Zawaj Doctors</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ml-auto">
                        <a class="nav-item nav-link" href="index.php" id='home'><i class="fa fa-home"></i>Home</a>
                        <a class="nav-item nav-link" href="account.php" id='update_account'>Account</a>
                        <?php
                        if(isset($_SESSION['username'])){
                            echo '<a class="nav-item nav-link" href="logout.php"><i class="fas fa-sign-out"></i>Logout</a>';
                        ?>
                        <?php 
                        } else {
                            echo '<a class="nav-item nav-link" href="register.php">Login or Register</a>';
                        }?>
                        <a class="nav-item nav-link" href="contact.php">Contact Us</a>
                    </div>
                </div>
        </nav>
        <main role="main" class="container starter-template">
            <div class="row">
                <div class="col-md-2">
                    <!-- Button to Trigger Modal -->
                    <button type="button" class="btn btn-primary" id="askQuestionTrigger" data-toggle="modal" class="action ask-question" data-target="#addQuestionModal">
                        <i class="fa fa-plus"></i> ASK A QUESTION                    
                    </button>
                    <?php
                        if(isset($_SESSION['username'])){
                            $username = $_SESSION['username'];
                            ?>
                            <!-- Modal -->
                            <div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                            <!-- where prompt / messages will appear -->
                                            <div id="response"></div>
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="add_question_form">
                                                <div class="form-group">
                                                    <label for="body">Question</label>
                                                    <textarea class="form-control" id="body" name="body" rows="3"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="category_name">Example select</label>
                                                    <select class="form-control" id="category_name" name="category_name">
                                                        <option value="Intimacy">Intimacy</option>
                                                        <option value="Parenting and Education">Parenting and Education</option>
                                                        <option value="Cooking">Cooking</option>
                                                        <option value="Housing">Housing</option>
                                                        <option value="Money">Money</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                        } else {
                            echo '<div class="card">
                                    <div class="card-header">Please sign in or register!</div>
                                    <div class="card-body">
                                        <h5 class="card-title">You are not logged in.</h5>
                                        <p class="card-text">To post questions and comment, you must sign in. Click <a href="register.php">here</a></p>
                                    </div>
                                </div>';
                        }?>
                </div>
                <div class="col-md-8">
                    <div class="col-md-8" id="content"></div>
                    <div class="col-md-4" id="right-content"></div>
                </div>
                <div class="col-md-2">
                    <h5>Top Users</h5>
                    <ol id="right-sidebar"></ol>
                </div>
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                //to display questions
                $.ajax({
                    type: "GET",
                    url: 'api/read_posts.php',
                    dataType: 'json', 
                    success: function (response) {
                        response.forEach(element => {       
                            
                            $("#content").append('<h5>'+element.body+'</h5><p><a href="#"><img class="profile_pic_placement" height="50px" width="50px" style="border-radius: 50%;"> '+element.author+'</a>  <span class="label_placement"></span> Asked on '+element.post_date+' at '+element.post_time+'<br><a href="comments.php?q='+element.id+'" style="float:right;">Comments</a></p><hr style="clear:both;">');
                            /*$("#right-content").append('<h5>'+element.body+'</h5><p>Posted on '+element.created+' by <a href="#">'+element.author+'</a> <br><a href="#">Comments</a></p><hr>');*/
                        });
                        
                    }
                });
                //to display top users
                $.ajax({
                    type: "GET",
                    url: 'api/read_users.php',
                    dataType: 'json', 
                    success: function (response) {
                        response.forEach(element => {       
                            
                            $("#right-sidebar").append('<li><a href="#">'+element.username+'</a> <span style="float:right;"><i class="fa fa-star"></i>'+element.points+'<span></li><hr>');
                            $(".profile_pic_placement").attr("src",""+element.profile_pic+"");
                            $(".label_placement").html(element.badge);
                        });
                        
                        
                    }
                });
                //to display categories filter 
                /*$.ajax({
                    type: "GET",
                    url: 'api/read_posts_by_category.php',
                    dataType: 'json', 
                    success: function (response) {
                        response.forEach(element => {       
                            
                            
                        });
                        
                        
                    }
                });*/
            });
            // trigger when add question form is submitted
            $(document).on('submit', '#add_question_form', function(e){  
                e.preventDefault(); 
                
                // get form data    
                var add_question_form=$(this);          
                var form_data=JSON.stringify(add_question_form.serializeObject());       
                // submit form data to api
                $.ajax({
                    url: "api/create_post.php",
                    type : "POST",
                    dataType: "json",
                    contentType : 'application/json;charset=utf-8',
                    data : form_data,
                    success : function(result) {  
                        clearResponse();  
                        // if true (1)
                            setTimeout(function(){// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 5000); 
                        
                        add_question_form.find('textarea').val('');
                        
                    },
                    error: function(xhr, resp, text){
                        // on error, tell the user sign up failed
                        $('#response').html("<div class='alert alert-danger'>Unable to create a new question</div>");           
                    }
                });
                return false;
                    
            });
            // remove any prompt messages
            function clearResponse(){
                $('#response').html('');
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
    
    
