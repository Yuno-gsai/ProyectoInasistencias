-- =====================================
-- Crear base de datos
-- =====================================
CREATE DATABASE IF NOT EXISTS control_inasistencias;
USE control_inasistencias;

-- =====================================
-- Tablas base (no modificables, solo cambio a InnoDB)
-- =====================================

-- Tabla alumno
CREATE TABLE IF NOT EXISTS alumno (
    idalumno INT AUTO_INCREMENT PRIMARY KEY,
    carnet VARCHAR(6) NOT NULL UNIQUE,
    nombre VARCHAR(20) NOT NULL,
    apellido VARCHAR(20) NOT NULL,
    telefono VARCHAR(9),
    sexo VARCHAR(1),
    foto VARCHAR(50),
    email VARCHAR(150),
    estadoAlumno INT(2),
    beca INT(2) DEFAULT 0,
    tipobeca VARCHAR(250)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla docente
CREATE TABLE IF NOT EXISTS docente (
    id_docente      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    carnet          CHAR(20) DEFAULT NULL,
    nom_usuario     CHAR(30) DEFAULT NULL,
    ape_usuario     CHAR(30) DEFAULT NULL,
    tipo            CHAR(30) DEFAULT NULL,
    estado          CHAR(20) DEFAULT NULL,
    clave           CHAR(50) DEFAULT NULL,
    permanente      INT(1) DEFAULT NULL,
    accesosistemas  INT(4) DEFAULT NULL,
    esadministrador INT(1) DEFAULT NULL,
    cambio          INT(1) DEFAULT NULL,
    esadminbecas    INT(1) DEFAULT NULL,
    PRIMARY KEY (id_docente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla detalle
CREATE TABLE IF NOT EXISTS detalle (
    id_detalle       INT(10) NOT NULL AUTO_INCREMENT,
    id_d             INT(10) DEFAULT NULL COMMENT 'id docente',
    id_g             INT(10) DEFAULT NULL COMMENT 'id grupo',
    id_m             INT(10) DEFAULT NULL COMMENT 'id materia',
    aula             VARCHAR(20) DEFAULT NULL,
    ha               TIME DEFAULT NULL,
    hf               TIME DEFAULT NULL,
    ciclo            VARCHAR(4) DEFAULT 'I',
    year             INT(4) DEFAULT NULL,
    dia              VARCHAR(25) DEFAULT NULL,
    grupo            VARCHAR(20) DEFAULT NULL,
    tipo             VARCHAR(4) DEFAULT NULL,
    horas            INT(2) DEFAULT NULL,
    version          VARCHAR(2) DEFAULT NULL,
    fechaini         DATE DEFAULT NULL,
    fechafin         DATE DEFAULT NULL,
    comentarioreserva BLOB DEFAULT NULL,
    carnetusuario    VARCHAR(20) DEFAULT NULL,
    cod_alldetalle   VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (id_detalle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla materia
CREATE TABLE IF NOT EXISTS materia (
    id_materia      INT(10) NOT NULL AUTO_INCREMENT,
    materia         VARCHAR(200) NOT NULL,
    id_departamento INT(60) DEFAULT NULL,
    curricula       VARCHAR(4) DEFAULT NULL,
    idcarrera       INT(11) DEFAULT NULL,
    ciclo           VARCHAR(6) DEFAULT NULL,
    uv              VARCHAR(2) DEFAULT NULL,
    ciclomateria    VARCHAR(6) DEFAULT NULL,
    codigomateria   VARCHAR(15) DEFAULT NULL,
    horasteoricas   INT(4) DEFAULT NULL,
    horaspracticas  INT(4) DEFAULT NULL,
    correlativo     INT(4) DEFAULT NULL,
    ciclonumero     INT(2) DEFAULT NULL,
    estado          INT(1) DEFAULT 1,
    esmateriabasica INT(1) DEFAULT 1,
    nombre_corto    VARCHAR(150) DEFAULT 'nd',
    PRIMARY KEY (id_materia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla grupo
CREATE TABLE IF NOT EXISTS grupo (
    id_grupo INT(10) NOT NULL AUTO_INCREMENT,
    grupo    VARCHAR(20) NOT NULL,
    tipo     VARCHAR(50) DEFAULT NULL,
    idcarrera INT(11) DEFAULT NULL,
    year     INT(4) DEFAULT NULL,
    ciclo    VARCHAR(6) DEFAULT NULL,
    estado   VARCHAR(15) DEFAULT 'Habilitado',
    PRIMARY KEY (id_grupo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla carrera
CREATE TABLE IF NOT EXISTS carrera (
    idcarrera        INT(11) NOT NULL AUTO_INCREMENT,
    carrera          VARCHAR(200) DEFAULT NULL,
    iddepto          INT(11) DEFAULT NULL,
    corto            VARCHAR(60) DEFAULT NULL,
    estadocarrera    VARCHAR(10) DEFAULT 'A',
    duracion         INT(11) DEFAULT NULL,
    turno_estudio    VARCHAR(50) DEFAULT 'dia',
    costo_matricula  DECIMAL(10,2) DEFAULT NULL,
    matriculas       INT(11) DEFAULT NULL,
    cuota_mensual    DECIMAL(10,2) DEFAULT NULL,
    cuotas_anuales   INT(11) DEFAULT NULL,
    costo_laboratorios DECIMAL(10,2) DEFAULT NULL,
    otros_costos     DECIMAL(10,2) DEFAULT NULL,
    PRIMARY KEY (idcarrera)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- =====================================
-- Tablas nuevas del sistema
-- =====================================

-- Tabla alumnos_extra (datos adicionales de los alumnos)
CREATE TABLE IF NOT EXISTS alumnos_extra (
    id_extra INT AUTO_INCREMENT PRIMARY KEY,
    idalumno INT NOT NULL,
    direccion VARCHAR(255),
    fecha_nacimiento DATE,
    contacto_emergencia VARCHAR(100),
    telefono_emergencia VARCHAR(9),
    observaciones TEXT,
    estado VARCHAR(15) DEFAULT 'Activo',
    motivo VARCHAR(255),
    CONSTRAINT fk_extra_alumno FOREIGN KEY (idalumno) REFERENCES alumno(idalumno)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla inasistencia
CREATE TABLE IF NOT EXISTS inasistencia (
    id_inasistencia INT AUTO_INCREMENT PRIMARY KEY,
    idalumno INT NOT NULL,
    id_docente INT(11) UNSIGNED NOT NULL,
    id_detalle INT NOT NULL,
    fecha_falta DATE NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    cantidadHoras INT,
    observacion TEXT,
    estado VARCHAR(15) DEFAULT 'Creada',
    justificando INT(1) DEFAULT 0,
    justificaion VARCHAR (255),
    CONSTRAINT fk_inas_alumno FOREIGN KEY (idalumno) REFERENCES alumno(idalumno) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_inas_docente FOREIGN KEY (id_docente) REFERENCES docente(id_docente) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_inas_detalle FOREIGN KEY (id_detalle) REFERENCES detalle(id_detalle) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabla seguimiento
CREATE TABLE IF NOT EXISTS seguimiento (
    id_seguimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_inasistencia INT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    accion VARCHAR(255),
    respuesta TEXT,
    CONSTRAINT fk_seg_inas FOREIGN KEY (id_inasistencia) REFERENCES inasistencia(id_inasistencia)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- =====================================
-- Inserts de prueba
-- =====================================

-- Alumnos
-- ========================
INSERT INTO alumno (carnet, nombre, apellido, telefono, sexo, foto, email, estadoAlumno, beca, tipobeca) VALUES
('A001', 'Juan', 'Pérez', '7777-1111', 'M', 'juan.jpg', 'juan@gmail.com', 1, 1, 'Completa'),
('A002', 'María', 'García', '7777-2222', 'F', 'maria.jpg', 'maria@gmail.com', 1, 0, NULL),
('A003', 'Carlos', 'Ramírez', '7777-3333', 'M', 'carlos.jpg', 'carlos@gmail.com', 1, 1, 'Media'),
('A004', 'Lucía', 'Fernández', '7777-4444', 'F', 'lucia.jpg', 'lucia@gmail.com', 0, 0, NULL),
('A005', 'Pedro', 'López', '7777-5555', 'M', 'pedro.jpg', 'pedro@gmail.com', 1, 1, 'Completa');

-- ========================
-- Datos extra alumnos
-- ========================
INSERT INTO alumnos_extra (idalumno, direccion, fecha_nacimiento, contacto_emergencia, telefono_emergencia, observaciones) VALUES
(1, 'San Salvador', '2000-05-10', 'Carlos Pérez', '7777-0000', 'Ninguna'),
(2, 'Santa Ana', '1999-08-15', 'Ana García', '7777-9999', 'Alergia leve'),
(3, 'San Miguel', '2001-03-22', 'José Ramírez', '7777-8888', 'Problemas de visión'),
(4, 'Sonsonate', '2000-12-05', 'Luis Fernández', '7777-7777', 'Asma'),
(5, 'La Libertad', '1998-07-30', 'Marta López', '7777-6666', 'Ninguna');

-- ========================
-- Docentes
-- ========================
INSERT INTO docente (carnet, nom_usuario, ape_usuario, estado, clave, permanente, accesosistemas, esadministrador, cambio, esadminbecas) VALUES
('D001', 'José', 'Morales', 'Activo', 'clave1', 1, 1, 1, 0, 0),
('D002', 'Marta', 'Jiménez', 'Activo', 'clave2', 0, 1, 0, 0, 0),
('D003', 'Roberto', 'Castro', 'Activo', 'clave3', 1, 0, 0, 0, 0),
('D004', 'Elena', 'Martínez', 'Inactivo', 'clave4', 0, 0, 0, 0, 0),
('D005', 'Andrés', 'Hernández', 'Activo', 'clave5', 1, 1, 0, 0, 1);

-- ========================
-- Materias
-- ========================
INSERT INTO materia (materia) VALUES
('Matemáticas I'),
('Programación I'),
('Inglés Técnico'),
('Bases de Datos'),
('Redes de Computadoras');

-- ========================
-- Grupos
-- ========================
INSERT INTO grupo (grupo, year, ciclo) VALUES
('Grupo 1', 2025, 'I'),
('Grupo 2', 2025, 'I'),
('Grupo 3', 2025, 'II'),
('Grupo 4', 2024, 'II'),
('Grupo 5', 2025, 'I');

-- ========================
-- Detalle (docente + grupo + materia)
-- ========================
INSERT INTO detalle (id_d, id_g, id_m, aula, ha, hf, ciclo, year, dia, grupo, horas) VALUES
(1, 1, 1, 'Aula 101', '08:00:00', '10:00:00', 'I', 2025, 'Lunes', 'Grupo 1', 2),
(2, 2, 2, 'Aula 102', '10:00:00', '12:00:00', 'I', 2025, 'Martes', 'Grupo 2', 2),
(3, 3, 3, 'Aula 201', '13:00:00', '15:00:00', 'II', 2025, 'Miércoles', 'Grupo 3', 2),
(4, 4, 4, 'Aula 301', '07:00:00', '09:00:00', 'II', 2024, 'Jueves', 'Grupo 4', 2),
(5, 5, 5, 'Aula 401', '09:00:00', '11:00:00', 'I', 2025, 'Viernes', 'Grupo 5', 2);

-- ========================
-- Inasistencias
-- ========================
INSERT INTO inasistencia (idalumno, id_docente, id_detalle, fecha_falta, cantidadHoras, observacion, estado, justificando, justificaion) VALUES
(1, 1, 1, '2025-02-10', 2, 'Alumno llamó para justificar', 'Creada', 1, 'Enfermedad'),
(2, 2, 2, '2025-02-11', 1, 'Se quedó sin bus', 'Creada', 0, 'Problema de transporte'),
(3, 3, 3, '2025-02-12', 2, 'Avisó con anticipación', 'Creada', 1, 'Problemas familiares'),
(4, 4, 4, '2025-02-13', 3, 'No respondió llamadas', 'Creada', 0, 'Inasistencia injustificada'),
(5, 5, 5, '2025-02-14', 1, 'Se presentó con incapacidad médica', 'Creada', 1, 'Accidente menor');

-- ========================
-- Seguimientos
-- ========================
INSERT INTO seguimiento (id_inasistencia, fecha, accion, respuesta) VALUES
(1, '2025-02-12 10:00:00', 'Llamada', 'Alumno confirma asistencia próxima clase'),
(2, '2025-02-13 11:00:00', 'Correo enviado', 'Sin respuesta del alumno'),
(3, '2025-02-14 09:30:00', 'Reunión con padres', 'Compromiso de mejorar asistencia'),
(4, '2025-02-15 14:00:00', 'Visita domiciliaria', 'No se encontró al alumno'),
(5, '2025-02-16 16:45:00', 'Mensaje por WhatsApp', 'Alumno respondió justificando con incapacidad');
