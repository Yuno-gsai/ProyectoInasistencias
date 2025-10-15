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

public function getAllEstudiantes($ciclo, $anio) {
    $conn = $this->getConnection();

    // 1️⃣ Datos generales por alumno
    $query = "SELECT 
                a.idalumno,
                a.carnet,
                a.nombre,
                a.apellido,
                a.email,
                a.estadoAlumno,
                a.beca,
                a.tipobeca,
                a.telefono,
                COUNT(DISTINCT CASE WHEN d.ciclo = :ciclo AND d.year = :anio THEN i.id_inasistencia END) AS total_faltas,
                COUNT(s.id_seguimiento) AS total_seguimientos,
                MAX(s.fecha) AS ultima_fecha_seguimiento
            FROM alumno a
            INNER JOIN alumnos_extra ae ON ae.idalumno = a.idalumno
            LEFT JOIN inasistencia i ON a.idalumno = i.idalumno
            LEFT JOIN detalle d ON i.id_detalle = d.id_detalle
            LEFT JOIN seguimiento s ON s.id_inasistencia = i.id_inasistencia
            WHERE ae.estado = 'Seguimiento'
            GROUP BY a.idalumno, a.carnet, a.nombre, a.apellido
            ORDER BY ultima_fecha_seguimiento DESC";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':ciclo', $ciclo);
    $stmt->bindParam(':anio', $anio);
    $stmt->execute();
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2️⃣ Faltas detalladas por alumno, pero filtradas por ciclo y año
    foreach ($alumnos as &$alumno) {
        $stmtFaltas = $conn->prepare(
            "SELECT i.id_inasistencia, i.fecha_falta, i.cantidadHoras, i.observacion, i.justificandO, i.justificaion
             FROM inasistencia i
             INNER JOIN detalle d ON i.id_detalle = d.id_detalle
             WHERE i.idalumno = :idalumno AND d.ciclo = :ciclo AND d.year = :anio
             ORDER BY i.fecha_falta ASC"
        );
        $stmtFaltas->bindParam(':idalumno', $alumno['idalumno']);
        $stmtFaltas->bindParam(':ciclo', $ciclo);
        $stmtFaltas->bindParam(':anio', $anio);
        $stmtFaltas->execute();
        $alumno['faltas'] = $stmtFaltas->fetchAll(PDO::FETCH_ASSOC);

        // 3️⃣ Seguimientos, **sin filtrar por ciclo ni año**
        $stmtSeguimientos = $conn->prepare(
            "SELECT s.id_seguimiento, s.fecha, s.accion, s.respuesta
             FROM seguimiento s
             INNER JOIN inasistencia i ON s.id_inasistencia = i.id_inasistencia
             WHERE i.idalumno = :idalumno
             ORDER BY s.fecha ASC"
        );
        $stmtSeguimientos->bindParam(':idalumno', $alumno['idalumno']);
        $stmtSeguimientos->execute();
        $alumno['seguimientos'] = $stmtSeguimientos->fetchAll(PDO::FETCH_ASSOC);
    }

    return $alumnos;
}


    

    public function FinSeguimieto($estado, $motivo, $idalumno, $fecha_estado){
        $query = "UPDATE alumnos_extra SET estado = :estado, motivo = :motivo, fecha_estado = :fecha_estado WHERE idalumno = :idalumno;";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'estado' => $estado,
            'motivo' => $motivo,
            'idalumno' => $idalumno,
            'fecha_estado' => $fecha_estado
        ]);
        return true;
    }

    public function getSeguimientosFinalizados() {
    $conn = $this->getConnection();

    // 1️⃣ Datos generales por alumno no activo, sin filtrar por ciclo o fecha
    $query = "SELECT 
                a.idalumno,
                a.carnet,
                a.nombre,
                a.apellido,
                a.email,
                a.estadoAlumno,
                a.beca,
                a.tipobeca,
                a.telefono,
                ae.estado,
                ae.motivo,
                ae.fecha_estado,
                ae.observaciones,
                COUNT(DISTINCT i.id_inasistencia) AS total_faltas,
                COUNT(DISTINCT s.id_seguimiento) AS total_seguimientos,
                MAX(s.fecha) AS ultima_fecha_seguimiento
            FROM alumno a
            INNER JOIN alumnos_extra ae ON ae.idalumno = a.idalumno
            LEFT JOIN inasistencia i ON a.idalumno = i.idalumno
            LEFT JOIN seguimiento s ON s.id_inasistencia = i.id_inasistencia
            WHERE ae.estado <> 'Activo' AND ae.estado <> 'Seguimiento'  
            GROUP BY 
                a.idalumno, a.carnet, a.nombre, a.apellido, a.email,
                a.estadoAlumno, a.beca, a.tipobeca, a.telefono,
                ae.estado, ae.motivo, ae.fecha_estado, ae.observaciones
            ORDER BY ultima_fecha_seguimiento DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2️⃣ Agregar todas las faltas y seguimientos detallados
    foreach ($alumnos as &$alumno) {
        // Faltas
        $stmtFaltas = $conn->prepare(
            "SELECT id_inasistencia, fecha_falta, cantidadHoras, observacion 
             FROM inasistencia 
             WHERE idalumno = :idalumno
             ORDER BY fecha_falta ASC"
        );
        $stmtFaltas->bindParam(':idalumno', $alumno['idalumno']);
        $stmtFaltas->execute();
        $alumno['faltas'] = $stmtFaltas->fetchAll(PDO::FETCH_ASSOC);

        // Seguimientos
        $stmtSeguimientos = $conn->prepare(
            "SELECT s.id_seguimiento, s.fecha, s.accion, s.respuesta 
             FROM seguimiento s
             INNER JOIN inasistencia i ON s.id_inasistencia = i.id_inasistencia
             WHERE i.idalumno = :idalumno
             ORDER BY s.fecha ASC"
        );
        $stmtSeguimientos->bindParam(':idalumno', $alumno['idalumno']);
        $stmtSeguimientos->execute();
        $alumno['seguimientos'] = $stmtSeguimientos->fetchAll(PDO::FETCH_ASSOC);
    }

    return $alumnos;
}

    
    
    

}


?>