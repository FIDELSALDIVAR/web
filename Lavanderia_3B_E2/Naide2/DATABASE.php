<?php
class Database{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host     = 'localhost';
        $this->db       = 'trabajoo';
        $this->user     = 'root';
        $this->password = "";
        $this->charset  = 'latin_spanish_ci';
    }

    function connect(){
        try {
            echo "conexion exitosa";
            $pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->db."","root","");
            return $pdo;
        }
          catch(PDOException $e) {
              echo $e->getMessage();
        }
    }

}
?>