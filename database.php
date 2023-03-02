<?php 
    class Database{
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $database = "book_shop";

        private $link;

        public function __construct()
        {
            $this->connectDB();
        }

        private function connectDB(){
            $this->link = new mysqli($this->host,$this->user,$this->password,$this->database);

            if($this->link->connect_error){
                echo "Something Went Wrong: ".$this->link->connect_error;
                die();
            }


        }

        public function select($sql){
            $result = $this->link->query($sql);
            if($result){
                return $result;
            }else{
                return false;
            }
        }

    }





?>