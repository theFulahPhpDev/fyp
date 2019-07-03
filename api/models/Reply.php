<?php
    class Reply {
    // DB Stuff
        private $conn;
        private $table = 'replies';

        // Properties
        public $id;
        public $content;
        public $author;
        public $answer_id;
        public $created;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get categories
        public function read() {
            // Create query
            $query = 'SELECT id, content, author, DATE_FORMAT(created, "%M %d, %Y") AS post_date, DATE_FORMAT(created, "%l:%i %p") AS post_time FROM ' . $this->table . ' WHERE answer_id = ?
            ORDER BY created DESC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);


            // Bind answer ID
            $stmt->bindParam(1, $this->answer_id);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Reply
        public function read_single(){
        // Create query
        $query = 'SELECT id, content, author, DATE_FORMAT(created, "%M %d, %Y") AS post_date, DATE_FORMAT(created, "%l:%i %p") AS post_time FROM ' . $this->table . '
            WHERE id = ?
            LIMIT 0,1';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            $this->id = $row['id'];
            $this->content = $row['content'];
            $this->author = $row['author'];
            $this->post_date = $row['post_date'];
            $this->post_time= $row['post_time'];
        }

        // Create Reply
        public function create() {
            // Create Query
            $query = 'INSERT INTO ' .
                $this->table . '
            SET
                content = :content,
                author = :author,
                answer_id = :answer_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->content = htmlspecialchars(strip_tags($this->content));
            

            // Bind data
            $stmt-> bindParam(':content', $this->content);
            $stmt-> bindParam(':author', $this->author);
            $stmt-> bindParam(':answer_id', $this->answer_id);
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);

            return false;
        }

        
        // Delete Reply
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // clean data
            //$this->id = htmlspecialchars(strip_tags($this->id));

            // Bind Data
            $stmt-> bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);

            return false;
        }
    }
