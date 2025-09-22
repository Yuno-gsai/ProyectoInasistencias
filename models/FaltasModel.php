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
        $query = "INSERT INTO inasistencia (idalumno,id_docente,id_detalle, fecha_falta, cantidadHoras, observacion) VALUES (:idalumno,:id_docente,:id_detalle, :fecha_falta, :cantidadHoras, :observacion)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'idalumno' => $data['idalumno'],
            'id_docente' => $data['id_docente'],
            'id_detalle' => $data['id_detalle'],
            'fecha_falta' => $data['fecha_falta'],
            'cantidadHoras' => $data['cantidadHoras'],
            'observacion' => $data['observacion']]);
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
        $query = "UPDATE inasistencia SET idalumno = :idalumno, id_docente = :id_docente, id_detalle = :id_detalle, fecha_falta = :fecha_falta, cantidadHoras = :cantidadHoras, observacion = :observacion WHERE id_inasistencia = :id_inasistencia";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute([
            'id_inasistencia' => $data['id_inasistencia'],
            'idalumno' => $data['idalumno'],
            'id_docente' => $data['id_docente'],
            'id_detalle' => $data['id_detalle'],
            'fecha_falta' => $data['fecha_falta'],
            'cantidadHoras' => $data['cantidadHoras'],
            'observacion' => $data['observacion']]);
        return true;
    } 


    public function cambiarEstado($id,$estado) {
        $query = "UPDATE inasistencia SET estado = :estado WHERE id_inasistencia = :id_inasistencia";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_inasistencia' => $id,'estado'=>$estado]);
        return true;
    }

    public function getAllAlumnos(){
        $query = "SELECT 
                    -- Datos del alumno
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
                    
                    -- Datos extra
                    ae.direccion,
                    ae.fecha_nacimiento,
                    ae.contacto_emergencia,
                    ae.telefono_emergencia,
                    ae.observaciones,
                    
                    -- Datos del ciclo y año desde detalle
                    d.ciclo,
                    d.year,
                    
                    -- Total de faltas en ese ciclo/año
                    COUNT(i.id_inasistencia) AS total_faltas
                    
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
                    
                GROUP BY 
                    a.idalumno, a.carnet, a.nombre, a.apellido, a.telefono, a.foto, 
                    a.email, a.estadoAlumno, a.beca, a.tipobeca,
                    ae.direccion, ae.fecha_nacimiento, ae.contacto_emergencia, 
                    ae.telefono_emergencia, ae.observaciones,
                    d.ciclo, d.year
                ORDER BY d.year DESC, d.ciclo ASC, a.nombre ASC";
    
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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