<?php
class clsConexion {
    private $host;
    private $nombreBaseDatos;
    private $usuario;
    private $clave;
    private $conexionPdo;
    private $estadoConexion;

    public function __construct($host = '127.0.0.1', $nombreBaseDatos = 'apimacizo', $usuario = 'root', $clave = '') {
        $this->host = $_ENV['DB_HOST'] ?? $host;
        $this->nombreBaseDatos = $_ENV['DB_NAME'] ?? $nombreBaseDatos;
        $this->usuario = $_ENV['DB_USERNAME'] ?? $usuario;
        $this->clave = $_ENV['DB_PASSWORD'] ?? $clave;
        $this->desconectar();
    }
    
    public function conectar(){
        try{
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->nombreBaseDatos;
            $this->conexionPdo = new PDO($dsn, $this->usuario, $this->clave);
            $this->conexionPdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->estadoConexion = true;
        }
        catch(PDOException $ex){
            $this->conexionPdo = null;
            $this->estadoConexion = false;
        }
        return $this->conexionPdo;
    }
    
    public function desconectar(){
        $this->estadoConexion = false;
        $this->conexionPdo = null;
    }

    public function __GET($atr){return $this->$atr;}
}
?>
