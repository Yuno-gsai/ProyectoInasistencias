<?php
require_once 'BaseModel.php';

class SeguimientosModel extends BaseModel{
    public function __construct(){
        parent::__construct();
        $this->table = "seguimiento";
    }

    public function getAllByEstudianteId($id_estudiante){
        $query = "SELECT 
                s.id_seguimiento,
                s.fecha       AS fecha_seguimiento,
                s.accion,
                s.respuesta,
                i.id_inasistencia,
                i.fecha_falta,
                i.cantidadHoras,
                i.observacion AS observacion_inasistencia,
                a.idalumno,
                a.carnet,
                a.nombre,
                a.apellido
            FROM seguimiento s
            INNER JOIN inasistencia i ON s.id_inasistencia = i.id_inasistencia
            INNER JOIN alumno a ON i.idalumno = a.idalumno
            WHERE a.idalumno = :id_estudiante
            ORDER BY a.idalumno, i.id_inasistencia, s.fecha;";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_estudiante' => $id_estudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Create($data){
        $query = "INSERT INTO $this->table (id_inasistencia, accion, respuesta) VALUES (:id_inasistencia, :accion, :respuesta);";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'id_inasistencia' => $data['id_inasistencia'],
            'accion' => $data['accion'],
            'respuesta' => $data['respuesta']
        ]);
        return true;
    }


}


?>