<?php 

    class Connection {
        protected $hostname = 'localhost';
        protected $username = 'root';
        protected $password = 'Yankees12!';
        protected $dbname = 'MovieSite';

        protected $db;
        protected $stmt;

        public function __construct() {
            try {
                $dsn = 'mysql:hostname='. $this->hostname.';dbname=' . $this->dbname;
                $this->db = new PDO($dsn, $this->username, $this->password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected Successfully";
            } catch (Exception $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        } 
        
        public function query($sql){
            $this->stmt = $this->db->prepare($sql);
        }

        // execute the prepared statement 
        public function execute(){
            return $this->stmt->execute();
        }

        public function bind($param, $value, $type = null){
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        // get result set as array of objects 
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // GET single record as object
        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get row count
        public function rowCount(){
            return $this->stmt->rowCount();
        }

    }
?>