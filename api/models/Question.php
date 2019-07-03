<?php 
  class Question {
    // DB stuff
    private $conn;
    private $table = 'questions';

    // Post Properties
    public $id;
    public $category_name;
    public $body;
    public $author;
    public $votes;
    public $created;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT id, category_name, body, author, votes, DATE_FORMAT(created, "%M %d, %Y") AS post_date, DATE_FORMAT(created, "%l:%i %p") AS post_time FROM ' . $this->table . ' ORDER BY created DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    //Get posts by category
    public function read_by_category() {
      // Create query
      $query = 'SELECT id, category_name, body, author, votes, DATE_FORMAT(created, "%M %d, %Y") AS post_date, DATE_FORMAT(created, "%l:%i %p") AS post_time FROM ' . $this->table . ' WHERE category_name = :category_name ORDER BY created DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT id, category_name, body, author,  DATE_FORMAT(created, "%M %d, %Y") AS post_date, DATE_FORMAT(created, "%l:%i %p") AS post_time FROM ' . $this->table . ' WHERE id = ?
          LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();
          
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->body = $row['body'];
          $this->author = $row['author'];
          $this->category_name= $row['category_name'];
          $this->post_date = $row['post_date'];
          $this->post_time= $row['post_time'];

          

          // get number of rows
            $num = $stmt->rowCount();
            if($num>0){
                return true;
            }
                return false;
    }

    // Create Post
    public function create($username) {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET body = :body, author = :author, category_name = :category_name, votes = :votes';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->body = htmlspecialchars(strip_tags($this->body));
          $this->author = htmlspecialchars(strip_tags($this->author));
          $this->category_name = htmlspecialchars(strip_tags($this->category_name));

          // Bind data
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':author', $username);
          $stmt->bindParam(':category_name', $this->category_name);
          $votes = 0;
          $stmt->bindParam(':votes', $votes);
          // Execute query
          if($stmt->execute()) {
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Update Post
    public function update($id) {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET  body = :body, author = :author, category_id = :category_id
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->body = htmlspecialchars(strip_tags($this->body));
          $this->author = htmlspecialchars(strip_tags($this->author));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':author', $this->author);
          $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':id', $id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Post
    public function delete($id) {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

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
    
  }