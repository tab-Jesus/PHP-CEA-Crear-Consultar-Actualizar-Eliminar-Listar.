

<?php

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $fecha_registro;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }
}

?>