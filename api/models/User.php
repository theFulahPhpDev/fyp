<?php

    class User{
    
        // database connection and table name
        private $conn;
        private $table_name = "users";
    
        // object properties
        public $id;
        public $firstname;
        public $lastname;
        public $username;
        public $gender;
        public $profile_pic;
        public $points;
        public $email;
        public $password;
        public $badge;
        
        // constructor
        public function __construct($db){
            $this->conn = $db;
        }

        // create new user record
        function create(){
        
            // insert query
            $query = "INSERT INTO " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                username = :username,
                gender = :gender,
                profile_pic = :profile_pic,
                points = :points,
                badge = :badge,
                email = :email,
                password = :password";
        
            // prepare the query
            $stmt = $this->conn->prepare($query);
        
            // sanitize the data
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->username=htmlspecialchars(strip_tags($this->username));
            $this->gender=htmlspecialchars(strip_tags($this->gender));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
        
            // bind the values
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':gender', $this->gender);
            $stmt->bindParam(':email', $this->email);
        
            // hash the password before saving to database
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        

            //Profile picture assignment
            $rand = rand(1, 2); //Random number between 1 and 2
            if($rand == 1)
                $profile_pic = "assets/profile_pics/defaults/head_deep_blue.png";
            else if($rand == 2)
                $profile_pic = "assets/profile_pics/defaults/head_emerald.png";

            $stmt->bindParam(':profile_pic', $profile_pic);
            $points = 20;
            $stmt->bindParam(':points', $points);
            $badge = '<span class="badge badge-secondary">Learner</span>';
            $stmt->bindParam(':badge', $badge);

            // execute the query, also check if query was successful
            if($stmt->execute()){
                return true;
            }
            
            return false;
        }
        
        
        // check if given email exist in the database
        function check_email_exists(){
        
            // query to check if email exists
            $query = "SELECT *
                    FROM " . $this->table_name . "
                    WHERE email = ?
                    LIMIT 0,1";
        
            // prepare the query
            $stmt = $this->conn->prepare( $query );
        
            // sanitize
            $this->email=htmlspecialchars(strip_tags($this->email));
        
            // bind given email value
            $stmt->bindParam(1, $this->email);
        
            // execute the query
            $stmt->execute();
        
            // get number of rows
            $num = $stmt->rowCount();
        

            if($num>0){

                // get record details / values
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                // assign values to object properties
                $this->id = $row['id'];
                $this->firstname = $row['firstname'];
                $this->lastname = $row['lastname'];
                $this->username = $row['username'];
                $this->password = $row['password'];
                // return true because email exists in the database
                return true;
            }
        
            // return false if email does not exist in the database
            return false;
        }
        
        function check_username_exists() {
            // query to check if username exists
            $query = "SELECT *
                    FROM " . $this->table_name . "
                    WHERE username = ?
                    LIMIT 0,1";
        
            // prepare the query
            $stmt = $this->conn->prepare( $query );
        
            // sanitize
            $this->username=htmlspecialchars(strip_tags($this->username));
        
            // bind given username value
            $stmt->bindParam(1, $this->username);
        
            // execute the query
            $stmt->execute();
        
            // get number of rows
            $num = $stmt->rowCount();
        
            
            if($num>0){
                // return true because username exists in the database
                return true;
            }
        
            // return false if username does not exist in the database
            return false;
        }
        public function read_single($id){
            // query to check if username exists
            $query = "SELECT *
                    FROM " . $this->table_name . "
                    WHERE id = ?
                    LIMIT 0,1";
        
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->profile_pic = $row['profile_pic'];
            $this->badge = $row['badge'];

            // get number of rows
            $num = $stmt->rowCount();
            if($num>0){
                return true;
            }
                return false;
        }
        // update a user record
        public function update(){
        
            // if password needs to be updated
            $password_set=!empty($this->password) ? ", password = :password" : "";
        
            // if no posted password, do not update the password
            $query = "UPDATE " . $this->table_name . "
                    SET
                        firstname = :firstname,
                        lastname = :lastname,
                        username = :username,
                        email = :email
                        {$password_set}
                    WHERE id = :id";
        
            // prepare the query
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->username=htmlspecialchars(strip_tags($this->username));
            $this->email=htmlspecialchars(strip_tags($this->email));
            //$this->profile_pic=htmlspecialchars(strip_tags($this->profile_pic));
            //$this->id = htmlspecialchars(strip_tags($this->id));
        
            // bind the values from the form
            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            //$stmt->bindParam(':profile_pic', $this->profile_pic);
            
        
            // hash the password before saving to database
            if(!empty($this->password)){
                $this->password=htmlspecialchars(strip_tags($this->password));
                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
            }
        
            // unique ID of record to be edited
            $stmt->bindParam(':id', $this->id);
        
            // execute the query
            if($stmt->execute()){
                return true;
            }
        
            return false;
        }
        //Update profile picture
        public function upload_pic($id,$path){
        
            
            // if no posted password, do not update the password
            $query = "UPDATE " . $this->table_name . "
                    SET
                        profile_pic = :profile_pic
                    WHERE id = :id";
        
            // prepare the query
            $stmt = $this->conn->prepare($query);
        
            
            
            $stmt->bindParam(':profile_pic', $path);
            
        
            // unique ID of record to be edited
            $stmt->bindParam(':id', $id);
        
            // execute the query
            if($stmt->execute()){
                return true;
            }
        
            return false;
        }

        // Delete user
        public function delete($id) {
            // Create query
            $query = 'DELETE FROM ' . $this->table_name . ' WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function addPoints($points,$username) {
            // if no posted password, do not update the password
            $query = "UPDATE " . $this->table_name . "
                    SET
                        points = points + :points
                    WHERE username = :username";
        
            // prepare the query
            $stmt = $this->conn->prepare($query);
        
            
            
            $stmt->bindParam(':points', $points);
            
            
            
            
            // unique username of record to be edited
            $stmt->bindParam(':username', $username);
        
            // execute the query
            if($stmt->execute()){
                return true;
                
            }
            
            return false;

        }

        
        

        public function update_badge($username) {
            // if no posted password, do not update the password
            $query = "UPDATE " . $this->table_name . "
                    SET
                        badge = :badge
                    WHERE username = :username";
        
            // prepare the query
            $stmt = $this->conn->prepare($query);
        
            /*$num_points =  $this->username->points;
            if($num_points >= 20 && $num_points <= 50){
                $badge = '<span class="badge badge-primary">Nurse</span>';
            }  elseif($num_points > 50 && $num_points <= 140){
                $badge = '<span class="badge badge-warning">Doctor</span>';
            } elseif($num_points > 140 && $num_points <= 200){
                $badge = '<span class="label label-success">Expert</span>';
            } elseif($num_points > 200 && $num_points <= 260){
                $badge = '<span class="label label-danger">Professor</span>';
            }*/

            $badge = '<span class="badge badge-primary">Student</span>';
                

            $stmt->bindParam(':badge', $badge);
            
        
            // unique username of record to be edited
            $stmt->bindParam(':username', $username);
        
            // execute the query
            if($stmt->execute()){
                return true;
            }
        
            return false;
        }

        // Get Users
        public function read() {
            // Create query
            $query = 'SELECT * FROM ' . $this->table_name.' ORDER BY points DESC';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Execute query
            $stmt->execute();
    
            return $stmt;
        }

    }  
        