<?php
require_once "BaseModel.php";

class Docente extends BaseModel {
    public function __construct() {
        parent::__construct();
        $this->table = "docente";
    }

    public function CustongetAll($carnet, $password ) {
        $query = "SELECT 
            id_docente,
            carnet,
            nom_usuario,
            ape_usuario,
            estado,
            permanente,
            accesosistemas,
            cambio,
            esadminbecas,
            esadmininassistencias 
            FROM {$this->table} 
            WHERE carnet = :carnet AND clave = :password";
    
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['carnet' => $carnet, 'password' => $password]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ?: false; 
    }

    function encriptar($accion, $texto)
    {
        $output = false;
        $encriptadormetodo = "AES-256-CBC";
        $palabrasecreta = "Luffy";
        $iv = "C9FBL1EWSD/M8JFTGS";
        $key = hash("sha256", $palabrasecreta);
        $siv = substr(hash("sha256", $iv), 0, 16);
        if ($accion == "encriptar") {
            $salida = openssl_encrypt($texto, $encriptadormetodo, $key, 0, $siv);
        } elseif ($accion == "desencriptar") {
            $salida = openssl_decrypt($texto, $encriptadormetodo, $key, 0, $siv);
        }
        return $salida;
    }

    public function cambiarContraseña($carnet, $password)
    {
        $query = "UPDATE {$this->table} SET clave = :password WHERE carnet = :carnet";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['carnet' => $carnet, 'password' => $this->encriptar('encriptar', $password)]);
        return true;
    }

    public function cambiarCambio($carnet){
        $query = "UPDATE {$this->table} SET cambio = 0 WHERE carnet = :carnet";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['carnet' => $carnet]);
        return true;
    }

    public function getCambio($carnet){
        $query = "SELECT cambio FROM {$this->table} WHERE carnet = :carnet";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['carnet' => $carnet]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cambio'];
    }

}

?>