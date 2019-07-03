<?php 
    session_start();
    
    $question_number = isset($_GET['q']) ? $_GET['q'] : die();

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Comments</title>   
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
                        <a class="nav-item nav-link" href="index.php" id='home'>Home</a>
                        <a class="nav-item nav-link" href="account.php">Account</a>
                        <?php
                        if(isset($_SESSION['username'])){
                            echo '<a class="nav-item nav-link" href="logout.php">Logout</a>';
                        ?>
                        <?php 
                        } else {
                            echo '<a class="nav-item nav-link" href="register.php">Login or Register</a>';
                        }?>
                        
                    </div>
                </div>
        </nav>
        <main role="main" class="container starter-template">
            <div class="row justify-content-md-center">
                <div class="col-md-8" id="content">
                    
                </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-8" id="commentBox">
                    
                            <div id="commentSection"></div>
                            <form id="add_comment_form" style="display:none">
                                <div class="form-group">
                                    <textarea placeholder="Write your comment here" id="content" name="content" rows="3" cols="50"></textarea>
                                </div>
                                <input type="hidden" class="question_id_placement" id="question_id" name="question_id"> 
                                <button class="btn btn-primary" type="submit">Submit</button>
                                
                            </form>

                        
                </div>
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            
            $(document).ready(function(){
                console.log("Page ready!");
                var num = <?php echo $question_number; ?>;
                
                //to display a single question 
                $.ajax({
                    type: "GET",
                    url: 'api/read_post.php?q='+num,
                    dataType: 'json', 
                    success: function (response) {
                        //console.log(response);
                        $("#content").append('<h5>'+response.body+'</h5><p><a href="#"><img id="profile_pic_placement" height="50px" width="50px" style="border-radius: 50%;"> '+response.author+'</a>  <span id="label_placement"></span> Asked on '+response.post_date+' at '+response.post_time+' in <a href="#">'+response.category_name+'</a><br><span style="float:right;"><a href="#"><i class="fa fa-chevron-up">Upvote</i></a> <a href="#" id="showCommentForm">Answer</a></span></p><hr style="clear:both;">');
                        $(".question_id_placement").attr("value",""+response.id+"");
                    },
                    error: function(xhr, resp, text){
                        // on error, tell the user sign up failed
                        console.log("Problem");
                        /*$('#response').html("<div class='alert alert-danger'>Unable to create a new question</div>");       */    
                    }
                });
                //to display author details
                $.ajax({
                    type: "GET",
                    url: 'api/read_user.php',
                    dataType: 'json', 
                    success: function (response) {
                        $("#profile_pic_placement").attr("src",""+response.profile_pic+"");
                        $("#label_placement").html(response.badge);             
                    }
                });
                $(document).on('click', '#showCommentForm', function(){
                    <?php 
                        if(isset($_SESSION['username'])){ ?>
                            $("#add_comment_form").show();
                <?php } else {?>
                            location.href="register.php";
                        <?php } ?>
                        
                });
                
                
                //To read answers 
                $.ajax({
                    type: "GET",
                    url: 'api/read_answers.php?q='+num,
                    dataType: 'json', 
                    success: function (response) {
                        response.forEach(element => {       
                            
                            $('#commentSection').append('<p>'+element.content+'</p><p><a href="#"><img class="comment_pic_placement" height="50px" width="50px" style="border-radius: 50%;"> '+element.author+'</a>  <span class="label_commentor_placement"></span> Posted on '+element.post_date+' at '+element.post_time+'<br><span style="float:right;"><a href="#" class="upvotingAnswer" data-id="'+element.id+'">Upvote</a> <a href="#">Reply</a></span></p><hr style="clear:both;">');
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
                            $(".comment_pic_placement").attr("src",""+element.profile_pic+"");
                            $(".label_commentor_placement").html(element.badge);
                        });
                        
                        
                    }
                });

                //function to update number of votes for a specific answer
                $(document).on('click', '.updatingAnswer', function(){
                    
                    //var answer_id = $(".updatingAnswer").attr("data-id");
                    console.log("hi");
                    /*$.ajax({
                        url: "api/update_answer_votes.php",
                        type : "POST",
                        contentType : 'application/json',
                        data: answer_id,
                        success: function (response) {                            
                            console.log("answer updated!");
                        },
                        error: function(xhr, resp, text){
                            console.log("No update!");     
                        }
                    });*/
                    
                });
            });//end of ready function
            
            // trigger when add question form is submitted
            $(document).on('submit', '#add_comment_form', function(e){ 
                    
                    
                    e.preventDefault(); 
                    // get form data    
                    var add_comment_form=$(this);   
                    
                    var form_data=JSON.stringify(add_comment_form.serializeObject()); 
                    
                    // submit form data to api
                    $.ajax({
                        url: 'api/create_answer.php',
                        type : "POST",
                        dataType: "json",
                        contentType : 'application/json;charset=utf-8',
                        data : form_data,
                        success : function(result) {  
                            console.log('good');
                            add_comment_form.find('textarea').val('');
                            /*$("#commentSection").append('<p>'+result.content+'</p><p><a href="#"><img id="comment_pic_placement" height="50px" width="50px" style="border-radius: 50%;"> '+result.author+'</a>  <span id="label_placement"></span> Posted on '+result.post_date+' at '+result.post_time+'<br><span style="float:right;"><a href="#"><i class="fa fa-chevron-up">Upvote</i></a> <a href="#" id="comment_id_placement">Reply</a></span></p><hr style="clear:both;">');*/
                        
                            
                        },
                        error: function(xhr, resp, text){
                            // on error, tell the user sign up failed
                            console.log("Problem!");
                            /*$('#response').html("<div class='alert alert-danger'>Unable to create a new question</div>");       */    
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
    
    
