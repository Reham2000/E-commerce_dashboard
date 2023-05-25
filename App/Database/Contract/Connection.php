<?php
namespace App\Database\Contract;
class Connection {
    private string $db_server = 'localhost';
    private string $db_username = 'root';
    private string $db_password = '';
    private string $db_name = 'nti_ecommerce';
    public \mysqli $conn;

    public function __construct(){
        $this->conn = new \mysqli($this->db_server,$this->db_username,
        $this->db_password,$this->db_name);
        
    }
}
new Connection;