<?php
class Database {
    private $host = "localhost";
    private $db_name = "projetophp";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host = " . $this->host . "; dbname ="
                . $this->db_name, $this->username, $this->password);
            $this->conn->exec("USE " . $this->db_name);
        } catch (PDOException $exception) {
            echo "erro de conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
