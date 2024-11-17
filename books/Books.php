<?php
    class Books {
        private $dbConn;
        public function __construct($p_dbConn){
            $this->dbConn = $p_dbConn;
        }
        public function getBooks(){
            $query = 'SELECT * FROM books';
            $stmt = $this->dbConn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function filterBooks($p_ISBN, $p_firstName, $p_lastName, $p_title, $p_description) 
        {
            $sql = 'SELECT * FROM books WHERE 1=1';
            $params = [];

         
            if ((!empty(trim($p_ISBN))) || $p_ISBN == "0")
            {
                $sql .= " AND ISBN LIKE :ISBN";   
                $params[':ISBN'] = '%'.$p_ISBN.'%';
            }
            if (!empty(trim($p_firstName)))
            {
                $sql .= " AND firstName LIKE :firstName";
                $params[':firstName'] = '%'.$p_firstName.'%';
            }
           if (!empty(trim($p_lastName)))
            {
                $sql .= " AND lastName LIKE :lastName";
                $params[':lastName'] = '%'.$p_lastName.'%';
            }
            if (!empty(trim($p_title)) || $p_title == "0")
            {
                $sql .= " AND title LIKE :title";
                $params[':title'] = '%'.$p_title.'%';
            }
            if (!empty(trim($p_description)) || $p_description == "0")
            {
                $sql .= " AND description LIKE :description";
                $params[':description'] = '%'.$p_description.'%';
            }
             
            $stmt = $this->dbConn->prepare($sql);

            foreach ($params as $param => $value)
            {
                $stmt->bindValue($param, $value, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function deleteBook($p_id)
        {
            $sql ='DELETE FROM books WHERE id = :id';
            $stms = $this->dbConn->prepare($sql);
            $stms->bindParam(':id', $p_id, PDO::PARAM_INT);
            return $stms->execute();
        }
        public function getBook($p_id)
        {
            $sql ='SELECT * FROM books WHERE id = :id';
            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(':id', $p_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function updateBook($p_id, $p_ISBN, $p_firstName, $p_lastName, $p_title, $p_description)
        {
            $sql = 'UPDATE books SET ISBN = :ISBN, firstName = :firstName, lastName = :lastName, title = :title, description = :description WHERE id = :id';
            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(':id', $p_id, PDO::PARAM_INT);
            $stmt->bindParam(':ISBN', $p_ISBN, PDO::PARAM_STR);
            $stmt->bindParam(':firstName', $p_firstName, PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $p_lastName, PDO::PARAM_STR);
            $stmt->bindParam(':title', $p_title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $p_description, PDO::PARAM_STR);
            return $stmt->execute(); 
        }
        public function addBook($p_ISBN, $p_firstName, $p_lastName, $p_title, $p_description)
        {
            $sql = 'INSERT INTO books (ISBN, firstName, lastName, title, description) VALUES (:ISBN, :firstName, :lastName, :title, :description)';
            $stmt = $this->dbConn->prepare($sql);
            $stmt->bindParam(':ISBN', $p_ISBN, PDO::PARAM_STR);
            $stmt->bindParam(':firstName', $p_firstName, PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $p_lastName, PDO::PARAM_STR);
            $stmt->bindParam(':title', $p_title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $p_description, PDO::PARAM_STR);
            return $stmt->execute(); 
        }
     }
?>       