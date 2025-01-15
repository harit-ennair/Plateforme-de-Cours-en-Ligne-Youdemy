<?php
namespace Youcode\youdemy;

use PDO;
use PDOException;
class database
{

    private $host = 'localhost';
    private $dbname = 'youdemy';
    private $username = 'root';
    private $password = '';
    private $pdo;


    public function __construct()
    {
        try {
 
            $conn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;

            $this->pdo = new PDO($conn, $this->username, $this->password);
       
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        } catch (PDOException $e) {

            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

