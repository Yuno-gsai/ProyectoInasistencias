<?php
require_once "BaseModel.php";

class Faltas extends BaseModel {
    public function __construct() {
        parent::__construct();
        $this->table = "inasistencia";
    }

    public function getAll() {
        $query = "SELECT * FROM inasistencia";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByEstudianteID($id) {
        $query = "SELECT * FROM inasistencia WHERE fk_carnetalum = :id";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO inasistencia (fk_carnetalum,fk_carnetdoc,fecha_auto, fechafalta, cantidadHoras, materia) VALUES (:fk_carnetalum,:fk_carnetdoc,:fecha_auto, :fechafalta, :cantidadHoras, :materia)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'fk_carnetalum' => $data['fk_carnetalum'],
            'fk_carnetdoc' => $data['fk_carnetdoc'],
            'fk_carnetalum' => $data['fk_carnetalum'],
            'fechafalta' => $data['fechafalta'],
            'cantidadHoras' => $data['cantidadHoras'],
            'materia' => $data['materia']]);
        return true;
    }
}

?>