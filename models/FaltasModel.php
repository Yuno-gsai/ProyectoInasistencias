<?php
require_once "BaseModel.php";

class Faltas extends BaseModel {
    public function __construct() {
        parent::__construct();
        $this->table = "inasistencia";
    }

    public function getAll() {
        $query = "SELECT * FROM inasistencia WHERE estado = 'Creada'";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByInasistenciaID($id) {
        $query = "SELECT 
                    -- Campos permitidos de alumno
                    a.idalumno,
                    a.carnet,
                    a.nombre,
                    a.apellido,
                    a.telefono,
                    a.foto,
                    a.email,
                    a.estadoAlumno,
                    a.beca,
                    a.tipobeca,
                    
                    -- Todo de alumnos_extra
                    ae.*,
                    
                    -- Todo de inasistencia
                    i.*,
                    
                    -- Todo de detalle
                    d.*,
                    
                    -- Todo de materia
                    m.*,
                    
                    -- Todo de grupo
                    g.*
                FROM alumno a
                INNER JOIN alumnos_extra ae 
                    ON a.idalumno = ae.idalumno
                INNER JOIN inasistencia i 
                    ON a.idalumno = i.idalumno
                INNER JOIN detalle d 
                    ON i.id_detalle = d.id_detalle
                INNER JOIN materia m 
                    ON d.id_m = m.id_materia
                INNER JOIN grupo g 
                    ON d.id_g = g.id_grupo
                WHERE i.id_inasistencia = :id_inasistencia AND i.estado = 'Creada'";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_inasistencia' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO inasistencia (idalumno, id_docente, id_detalle, fecha_falta, cantidadHoras, observacion, justificacion_texto, justificacion_imagen, tiene_justificacion) 
                  VALUES (:idalumno, :id_docente, :id_detalle, :fecha_falta, :cantidadHoras, :observacion, :justificacion_texto, :justificacion_imagen, :tiene_justificacion)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'idalumno' => $data['idalumno'],
            'id_docente' => $data['id_docente'],
            'id_detalle' => $data['id_detalle'],
            'fecha_falta' => $data['fecha_falta'],
            'cantidadHoras' => $data['cantidadHoras'],
            'observacion' => $data['observacion'],
            'justificacion_texto' => $data['justificacion_texto'] ?? null,
            'justificacion_imagen' => $data['justificacion_imagen'] ?? null,
            'tiene_justificacion' => $data['tiene_justificacion'] ?? 0
        ]);
        return true;
    }

    public function getFaltasByDocenteId($id) {
        $query = "SELECT 
                    -- Campos permitidos de alumno
                    a.idalumno,
                    a.carnet,
                    a.nombre,
                    a.apellido,
                    a.telefono,
                    a.foto,
                    a.email,
                    a.estadoAlumno,
                    a.beca,
                    a.tipobeca,
                    
                    -- Todo de alumnos_extra
                    ae.*,
                    
                    -- Todo de inasistencia
                    i.*,
                    
                    -- Todo de detalle
                    d.*,
                    
                    -- Todo de materia
                    m.*,
                    
                    -- Todo de grupo
                    g.*
                FROM alumno a
                INNER JOIN alumnos_extra ae 
                    ON a.idalumno = ae.idalumno
                INNER JOIN inasistencia i 
                    ON a.idalumno = i.idalumno
                INNER JOIN detalle d 
                    ON i.id_detalle = d.id_detalle
                INNER JOIN materia m 
                    ON d.id_m = m.id_materia
                INNER JOIN grupo g 
                    ON d.id_g = g.id_grupo
                WHERE i.id_docente = :id_docente AND i.estado = 'Creada'";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_docente' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update($data) {
        $query = "UPDATE inasistencia SET 
                  idalumno = :idalumno, 
                  id_docente = :id_docente, 
                  id_detalle = :id_detalle, 
                  fecha_falta = :fecha_falta, 
                  cantidadHoras = :cantidadHoras, 
                  observacion = :observacion,
                  justificacion_texto = :justificacion_texto,
                  justificacion_imagen = :justificacion_imagen,
                  tiene_justificacion = :tiene_justificacion
                  WHERE id_inasistencia = :id_inasistencia";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'id_inasistencia' => $data['id_inasistencia'],
            'idalumno' => $data['idalumno'],
            'id_docente' => $data['id_docente'],
            'id_detalle' => $data['id_detalle'],
            'fecha_falta' => $data['fecha_falta'],
            'cantidadHoras' => $data['cantidadHoras'],
            'observacion' => $data['observacion'],
            'justificacion_texto' => $data['justificacion_texto'] ?? null,
            'justificacion_imagen' => $data['justificacion_imagen'] ?? null,
            'tiene_justificacion' => $data['tiene_justificacion'] ?? 0
        ]);
        return true;
    } 


    public function cambiarEstado($id,$estado) {
        $query = "UPDATE inasistencia SET estado = :estado WHERE id_inasistencia = :id_inasistencia";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_inasistencia' => $id,'estado'=>$estado]);
        return true;
    }

public function getAllAlumnos($ciclo, $anio) {
    $conn = $this->getConnection();

    // 1️⃣ Datos generales por alumno, filtrando por ciclo, año y estado activo
    $query = "SELECT 
                a.idalumno,
                a.carnet,
                a.nombre,
                a.apellido,
                a.telefono,
                a.foto,
                a.email,
                a.estadoAlumno,
                a.beca,
                a.tipobeca,
                ae.direccion,
                ae.fecha_nacimiento,
                ae.contacto_emergencia,
                ae.telefono_emergencia,
                ae.observaciones,
                d.ciclo,
                d.year,
                COUNT(i.id_inasistencia) AS total_faltas
            FROM alumno a
            INNER JOIN alumnos_extra ae ON a.idalumno = ae.idalumno
            LEFT JOIN inasistencia i ON a.idalumno = i.idalumno
            LEFT JOIN detalle d ON i.id_detalle = d.id_detalle
            WHERE d.ciclo = :ciclo AND d.year = :anio
              AND ae.estado = 'Activo'
            GROUP BY 
                a.idalumno, a.carnet, a.nombre, a.apellido, a.telefono, a.foto, 
                a.email, a.estadoAlumno, a.beca, a.tipobeca,
                ae.direccion, ae.fecha_nacimiento, ae.contacto_emergencia, 
                ae.telefono_emergencia, ae.observaciones,
                d.ciclo, d.year
            ORDER BY d.year DESC, d.ciclo ASC, a.nombre ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':ciclo', $ciclo);
    $stmt->bindParam(':anio', $anio);
    $stmt->execute();
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2️⃣ Faltas detalladas, también filtradas por ciclo y año
    $queryFaltas = "SELECT 
                        i.id_inasistencia,
                        i.idalumno,
                        i.fecha_falta,
                        i.cantidadHoras,
                        i.observacion,
                        i.justificandO,
                        i.justificaion,
                        i.justificacion_texto,
                        i.justificacion_imagen,
                        i.tiene_justificacion,
                        d.ciclo,
                        d.year,
                        m.materia,
                        doc.nom_usuario AS nombre_docente,
                        doc.ape_usuario AS apellido_docente
                    FROM inasistencia i
                    INNER JOIN detalle d ON i.id_detalle = d.id_detalle
                    INNER JOIN materia m ON d.id_m = m.id_materia
                    INNER JOIN docente doc ON i.id_docente = doc.id_docente
                    INNER JOIN alumnos_extra ae ON i.idalumno = ae.idalumno
                    WHERE d.ciclo = :ciclo AND d.year = :anio
                      AND ae.estado = 'Activo'
                    ORDER BY i.idalumno, i.fecha_falta ASC";
    
    $stmt = $conn->prepare($queryFaltas);
    $stmt->bindParam(':ciclo', $ciclo);
    $stmt->bindParam(':anio', $anio);
    $stmt->execute();
    $faltas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3️⃣ Asociar las faltas a cada alumno
    foreach ($alumnos as &$alumno) {
        $alumno['faltas_detalle'] = array_filter($faltas, function($f) use ($alumno) {
            return $f['idalumno'] == $alumno['idalumno'];
        });
    }

    return $alumnos;
}

    public function getFaltasByAlumno($idalumno){
        $query = "SELECT 
                    a.idalumno,
                    ANY_VALUE(a.carnet) AS carnet,
                    ANY_VALUE(a.nombre) AS nombre,
                    ANY_VALUE(a.apellido) AS apellido,
                    ANY_VALUE(a.telefono) AS telefono,
                    ANY_VALUE(a.foto) AS foto,
                    ANY_VALUE(a.email) AS email,
                    ANY_VALUE(a.estadoAlumno) AS estadoAlumno,
                    ANY_VALUE(a.beca) AS beca,
                    ANY_VALUE(a.tipobeca) AS tipobeca,
                    
                    ANY_VALUE(ae.direccion) AS direccion,
                    ANY_VALUE(ae.fecha_nacimiento) AS fecha_nacimiento,
                    ANY_VALUE(ae.contacto_emergencia) AS contacto_emergencia,
                    ANY_VALUE(ae.telefono_emergencia) AS telefono_emergencia,
                    ANY_VALUE(ae.observaciones) AS observaciones,

                    JSON_ARRAYAGG(
                        JSON_OBJECT(
                            'id_inasistencia', i.id_inasistencia,
                            'observacion', i.observacion,
                            'cantidadHoras', i.cantidadHoras,
                            'fecha_falta', i.fecha_falta,
                            'estado', i.estado,
                            'materia', m.materia,
                            'grupo', g.grupo
                        )
                    ) AS faltas
                FROM alumno a
                INNER JOIN alumnos_extra ae ON a.idalumno = ae.idalumno
                INNER JOIN inasistencia i ON a.idalumno = i.idalumno
                INNER JOIN detalle d ON i.id_detalle = d.id_detalle
                INNER JOIN materia m ON d.id_m = m.id_materia
                INNER JOIN grupo g ON d.id_g = g.id_grupo
                WHERE i.idalumno = :idalumno
                GROUP BY a.idalumno";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['idalumno' => $idalumno]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}




?>