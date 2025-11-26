<?php
require_once "BaseModel.php";

class Alumno extends BaseModel {
    public function __construct() {
        parent::__construct();
        $this->table = "alumno";
    }

    public function getAlumnos (){
        $query = "SELECT
            idalumno,
            carnet,
            nombre,
            apellido,
            telefono,
            sexo,
            foto,
            email,
            estadoAlumno,
            beca,
            tipobeca FROM alumno;";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function makerelation($idalumno) {
        $query = "INSERT INTO ina_alumnos_extra (idalumno) VALUES (:idalumno)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([':idalumno' => $idalumno]);
    }


public function getExtrasById($idalumno) {
    $query = "SELECT 
                    ae.id_extra,
                    ae.idalumno,
                    ae.direccion,
                    ae.fecha_nacimiento,
                    ae.contacto_emergencia,
                    ae.telefono_emergencia,
                    ae.observaciones,
                    ae.estado,
                    ae.motivo,
                    ae.fecha_estado
                FROM ina_alumnos_extra ae
                WHERE ae.idalumno = :idalumno";
    $stmt = $this->getConnection()->prepare($query);
    $stmt->execute([':idalumno' => $idalumno]);
    
    // Retorna un solo registro (porque un alumno solo tiene un registro extra)
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function getAll() {
        $query = "SELECT                             
                    a.idalumno,
                    a.carnet,
                    a.nombre,
                    a.apellido,
                    a.telefono,
                    a.sexo,
                    a.foto,
                    a.email,
                    a.estadoAlumno,
                    a.beca,
                    a.tipobeca,
                    ae.id_extra,
                    ae.idalumno AS fk_alumno,
                    ae.direccion,
                    ae.fecha_nacimiento,
                    ae.contacto_emergencia,
                    ae.telefono_emergencia,
                    ae.observaciones
                FROM alumno a
                INNER JOIN ina_alumnos_extra ae 
                    ON a.idalumno = ae.idalumno
                WHERE a.estadoAlumno = 1";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAlumnoById($id) {
        $query = "SELECT 
                    a.idalumno,
                    a.carnet,
                    a.nombre,
                    a.apellido,
                    a.telefono,
                    a.sexo,
                    a.foto,
                    a.email,
                    a.estadoAlumno,
                    a.beca,
                    a.tipobeca,
                    ae.id AS id_extra,
                    ae.fk_alumno,
                    ae.motivo,
                    ae.observacion,
                    ae.tel_fijo,
                    ae.correopersonal,
                    ae.ciclo_academico,
                    ae.anio
                FROM alumno a
                INNER JOIN ina_alumnos_extra ae 
                    ON a.idalumno = ae.idalumno
                WHERE a.idalumno = :idalumno";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['idalumno' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getAllByEmail($email) {
        $query = "SELECT 
                    a.idalumno,
                    a.carnet,
                    a.nombre,
                    a.apellido,
                    a.telefono,
                    a.sexo,
                    a.foto,
                    a.email,
                    a.estadoAlumno,
                    a.beca,
                    a.tipobeca,
                    ae.id AS id_extra,
                    ae.fk_alumno,
                    ae.motivo,
                    ae.observacion,
                    ae.tel_fijo,
                    ae.correopersonal,
                    ae.ciclo_academico,
                    ae.anio
                FROM alumno a
                INNER JOIN ina_alumnos_extra ae 
                    ON a.idalumno = ae.fk_alumno
                WHERE a.email = :email";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function agregarFalta($carnet, $fecha, $motivo, $observacion) {
        $query = "INSERT INTO ina_inasistencia (fk_carnetalum, fecha_auto, fechafalta, cantidadHoras, materia) VALUES (:carnet, :fecha, :fecha, :motivo, :observacion)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['carnet' => $carnet, 'fecha' => $fecha, 'motivo' => $motivo, 'observacion' => $observacion]);
        return true;
    }

    public function cambiarEstado($estado, $alumnoID){
        $query = "UPDATE  ina_alumnos_extra SET estado = :estado WHERE idalumno = :idalumno";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['estado' => $estado, 'idalumno' => $alumnoID]);
        return true;
    }
}

?>