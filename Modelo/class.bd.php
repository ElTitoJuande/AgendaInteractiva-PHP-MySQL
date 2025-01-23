<?php
        require_once('../../../cred.php');
    class db{

        private $conn;

        public function __construct(){
            $this->conn = new mysqli("Localhost", USU_CONN, PSW_CONN, "agenda_final");
        }

        // Método para obtener la conexión mysqli
        public function getConn() {
            return $this->conn;
        }
    }

?>