<?php
    class Database {
        public static $connection;

        function __construct(){
            $this->openConnection();
        }

        private function openConnection(){
            if(Self::$connection){
                return;
            }

            $dsn = "mysql:host=localhost;dbname=leadway";
            try {
                Self::$connection = new PDO($dsn,'root','');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }

    $database = new Database();
    $db =& $database;

?>