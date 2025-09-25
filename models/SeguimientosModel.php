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

    public function getAllEstudiantes(){
        $query = "SELECT 
                a.idalumno,
                a.carnet,
                a.nombre,
                a.apellido,
                COUNT(DISTINCT i.id_inasistencia) AS total_faltas,
                COUNT(s.id_seguimiento) AS total_seguimientos,
                MAX(s.fecha) AS ultima_fecha_seguimiento
            FROM alumno a
            INNER JOIN inasistencia i ON a.idalumno = i.idalumno
            INNER JOIN seguimiento s ON s.id_inasistencia = i.id_inasistencia
            GROUP BY a.idalumno, a.carnet, a.nombre, a.apellido
            HAVING COUNT(s.id_seguimiento) > 0
            ORDER BY ultima_fecha_seguimiento DESC;";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function FinSeguimieto($data){
        $query = "UPDATE alumnos_extra SET estado = :estado, motivo = :motivo, observaciones = :observaciones WHERE idalumno = :idalumno;";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'estado' => $data['estado'],
            'motivo' => $data['motivo'],
            'observaciones' => $data['observaciones'],
            'idalumno' => $data['idalumno']
        ]);
        return true;
    }

    public function getSeguimietosFinalizados(){
        $query = "SELECT 
                a.idalumno,
                a.carnet,
                a.nombre,
                a.apellido,
                ae.estado,
                ae.motivo,
                ae.observaciones,
                COUNT(DISTINCT i.id_inasistencia) AS total_faltas,
                COUNT(s.id_seguimiento) AS total_seguimientos
            FROM alumno a
            INNER JOIN alumnos_extra ae ON ae.idalumno = a.idalumno
            INNER JOIN inasistencia i ON i.idalumno = a.idalumno
            INNER JOIN seguimiento s ON s.id_inasistencia = i.id_inasistencia
            WHERE ae.estado <> 'Activo'
            GROUP BY 
                a.idalumno, 
                a.carnet, 
                a.nombre, 
                a.apellido, 
                ae.estado, 
                ae.motivo, 
                ae.observaciones
            ORDER BY a.idalumno;
            ";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>