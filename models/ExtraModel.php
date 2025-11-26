<?php
require_once "BaseModel.php";

class Extra extends BaseModel {

    public function __construct() {
        parent::__construct();
        $this->table = "ina_alumnos_extra";
    }

    // Obtiene todos los alumnos con su información extra (si existe)
    public function getAllWithAlumno() {
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
                    ae.observaciones,
                    ae.estado,
                    ae.motivo,
                    ae.fecha_estado
                FROM alumno a
                LEFT JOIN ina_alumnos_extra ae 
                    ON a.idalumno = ae.idalumno";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene la información extra de un alumno por idalumno
    public function getByAlumnoId($idalumno) {
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
                    ae.observaciones,
                    ae.estado,
                    ae.motivo,
                    ae.fecha_estado
                FROM alumno a
                INNER JOIN ina_alumnos_extra ae 
                    ON a.idalumno = ae.idalumno
                WHERE a.idalumno = :idalumno";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['idalumno' => $idalumno]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Inserta un registro nuevo en ina_alumnos_extra
    public function insertExtra($data) {
        $query = "INSERT INTO ina_alumnos_extra (
                        idalumno,
                        direccion,
                        fecha_nacimiento,
                        contacto_emergencia,
                        telefono_emergencia,
                        observaciones,
                        estado,
                        motivo,
                        fecha_estado
                    ) VALUES (
                        :idalumno,
                        :direccion,
                        :fecha_nacimiento,
                        :contacto_emergencia,
                        :telefono_emergencia,
                        :observaciones,
                        :estado,
                        :motivo,
                        :fecha_estado
                    )";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'idalumno'           => $data['idalumno'],
            'direccion'          => $data['direccion'] ?? null,
            'fecha_nacimiento'   => $data['fecha_nacimiento'] ?? null,
            'contacto_emergencia'=> $data['contacto_emergencia'] ?? null,
            'telefono_emergencia'=> $data['telefono_emergencia'] ?? null,
            'observaciones'      => $data['observaciones'] ?? null,
            'estado'             => $data['estado'] ?? 'Activo',
            'motivo'             => $data['motivo'] ?? null,
            'fecha_estado'       => $data['fecha_estado'] ?? null,
        ]);

        return true;
    }

    // Actualiza un registro extra por id_extra
    public function updateExtra($id_extra, $data) {
        $query = "UPDATE ina_alumnos_extra SET
                        direccion = :direccion,
                        fecha_nacimiento = :fecha_nacimiento,
                        contacto_emergencia = :contacto_emergencia,
                        telefono_emergencia = :telefono_emergencia,
                        observaciones = :observaciones,
                        estado = :estado,
                        motivo = :motivo,
                        fecha_estado = :fecha_estado
                    WHERE id_extra = :id_extra";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'id_extra'           => $id_extra,
            'direccion'          => $data['direccion'] ?? null,
            'fecha_nacimiento'   => $data['fecha_nacimiento'] ?? null,
            'contacto_emergencia'=> $data['contacto_emergencia'] ?? null,
            'telefono_emergencia'=> $data['telefono_emergencia'] ?? null,
            'observaciones'      => $data['observaciones'] ?? null,
            'estado'             => $data['estado'] ?? 'Activo',
            'motivo'             => $data['motivo'] ?? null,
            'fecha_estado'       => $data['fecha_estado'] ?? null,
        ]);

        return true;
    }
}

?>












