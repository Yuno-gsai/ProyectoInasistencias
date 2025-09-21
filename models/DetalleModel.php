<?php
require_once "BaseModel.php";

class DetalleModel extends BaseModel {
    public function __construct(){
        parent::__construct();
        $this->table = "detalle";
    }

    public function getAllByDocenteId($id_docente){
        $query = "SELECT 
                    d.*, 
                    g.grupo AS nombre_grupo, g.year AS año_grupo, g.ciclo AS ciclo_grupo,
                    m.materia AS nombre_materia, m.id_departamento, m.idcarrera
                FROM detalle d
                JOIN grupo g ON d.id_g = g.id_grupo
                JOIN materia m ON d.id_m = m.id_materia
                WHERE d.id_d = :id_docente;";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_docente' => $id_docente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>