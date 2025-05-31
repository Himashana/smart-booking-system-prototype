<?php
    if(!class_exists('DBconnect')){
        require_once 'envLoader.php';
        loadEnv(__DIR__ . '/.env');

        class DBconnect{
            // Database connection details.
            private $servername;
            private $username;
            private $password;
            private $dbname;

            function __construct() {
                $this->servername = $_ENV['DB_HOST'];
                $this->username = $_ENV['DB_USER'];
                $this->password = $_ENV['DB_PASS'];
                $this->dbname = $_ENV['DB_NAME'];
            }

            function MakeConn(){
                $dbconnect = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

                if(mysqli_connect_errno()){
                    die('Database connection failed');
                    // die('Database connection failed : '. mysqli_connect_error());
                }
                return $dbconnect;
            }

            function CloseConn(){
                mysqli_close(mysqli_connect($this->servername, $this->username, $this->password, $this->dbname));
            }

            function ExecuteQuery($query){
                $results = mysqli_query(mysqli_connect($this->servername, $this->username, $this->password, $this->dbname), $query);
                return $results;
            }
        }
    }
?>