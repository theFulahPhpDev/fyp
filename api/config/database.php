<?php
    // used to get mysql database connection
    class Database{
    
        // specify your own database credentials
        private $host = "localhost";
        private $db_name = "fyp_api_db";
        private $username = "root";
        private $password = "";
        public $conn;
    
        // get the database connection
        public function getConnection(){
    
            $this->conn = null;
    
            try{
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Connection error: " . $e->getMessage();
            }
    
            return $this->conn;
        }
    }
