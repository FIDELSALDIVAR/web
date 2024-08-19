<?php
class Database{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host     = 'sql110.infinityfree.com';
        $this->db       = 'if0_37139738_trabajoo';
        $this->user     = 'if0_37139738';
        $this->password = "L8UZTNCN4F";
        $this->charset  = 'latin_spanish_ci';
    }

    function connect(){
        try {
            echo "conexion exitosa";
            $pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->db."","if0_37139738","L8UZTNCN4F");
            return $pdo;
        }
          catch(PDOException $e) {
              echo $e->getMessage();
        }
    }

}
?>