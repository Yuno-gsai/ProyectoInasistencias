-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS control_inasistencias;
USE control_inasistencias;

-- ========================
-- Tabla: Alumnos
-- ========================
CREATE TABLE alumno (
    idalumno INT AUTO_INCREMENT PRIMARY KEY,
    carnet VARCHAR(6) NOT NULL UNIQUE,
    nombre VARCHAR(20) NOT NULL,
    apellido VARCHAR(20) NOT NULL,
    telefono VARCHAR(9),
    sexo VARCHAR(1),
    foto VARCHAR(50),
    email VARCHAR(150),
    estadoAlumno INT(2),
    beca INT(2) DEFAULT 0,   -- 0 = no becado, 1 = becado
    tipobeca VARCHAR(250)
);

CREATE TABLE alumnos_extra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fk_alumno INT NOT NULL,
    motivo VARCHAR(255),
    observacion TEXT,
    tel_fijo VARCHAR(20),
    correopersonal VARCHAR(100),
    ciclo_academico VARCHAR(50),
    anio INT,
    FOREIGN KEY (fk_alumno) REFERENCES alumno(idalumno)
);



-- ========================
-- Tabla: Docente
-- ========================
CREATE TABLE docente (
    id_docente INT AUTO_INCREMENT PRIMARY KEY,
    carnet VARCHAR(50) NOT NULL UNIQUE,
    nom_usuario VARCHAR(100) NOT NULL,
    ape_usuario VARCHAR(100) NOT NULL,
    estado VARCHAR(50),
    clave VARCHAR(255) NOT NULL,
    permanente TINYINT(1) DEFAULT 0,
    accesosistemas VARCHAR(100),
    cambio VARCHAR(100),
    esadminbecas TINYINT(1) DEFAULT 0,
    esadmininassistencias TINYINT(1) DEFAULT 0
);

-- ========================
-- Tabla: Inasistencia
-- ========================
CREATE TABLE inasistencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fk_carnetalum INT NOT NULL,
    fk_carnetdoc INT NOT NULL,
    fk_cargadecarrera INT,   -- parece que falta definir esta tabla
    fecha_auto DATE DEFAULT (CURRENT_DATE),
    fechafalta DATE NOT NULL,
    cantidadHoras INT,
    materia VARCHAR(100),
    FOREIGN KEY (fk_carnetalum) REFERENCES alumno(idalumno),
    FOREIGN KEY (fk_carnetdoc) REFERENCES docente(id_docente)
);

-- ========================
-- Tabla: CargaTrabajo
-- ========================
CREATE TABLE cargatrabajo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    horas INT,
    periodo VARCHAR(50)
);

-- ========================
-- Tabla: Seguimientos
-- ========================
CREATE TABLE seguimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fk_id_alumno INT NOT NULL,
    fecha DATE NOT NULL,
    accion VARCHAR(255),
    respuesta TEXT,
    FOREIGN KEY (fk_id_alumno) REFERENCES alumno(idalumno)
);



-- ========================
-- Inserts para tabla: alumnos
-- ========================
INSERT INTO alumno (carnet, nombre, apellido, telefono, sexo, foto, email, estadoAlumno, beca, tipobeca) VALUES
('A001', 'Juan', 'Pérez', '7777-1111', 'M', 'juan.jpg', 'juan@gmail.com', 1, 1, 'Completa'),
('A002', 'María', 'García', '7777-2222', 'F', 'maria.jpg', 'maria@gmail.com', 1, 0, NULL),
('A003', 'Carlos', 'López', '7777-3333', 'M', 'carlos.jpg', 'carlos@gmail.com', 0, 1, 'Parcial'),
('A004', 'Ana', 'Martínez', '7777-4444', 'F', 'ana.jpg', 'ana@gmail.com', 1, 0, NULL),
('A005', 'Luis', 'Hernández', '7777-5555', 'M', 'luis.jpg', 'luis@gmail.com', 2, 0, NULL);


-- ========================
-- Inserts para tabla: docente
-- ========================
INSERT INTO docente (carnet, nom_usuario, ape_usuario, estado, clave, permanente, accesosistemas, cambio, esadminbecas,esadmininassistencias) VALUES
('D001', 'José', 'Morales', 'Activo', 'clave1', 1, 'si', 'no', 1,1),
('D002', 'Marta', 'Jiménez', 'Activo', 'clave2', 0, 'si', 'no', 0,0),
('D003', 'Pablo', 'Castro', 'Activo', 'clave3', 1, 'si', 'no', 0,0),
('D004', 'Lucía', 'Vargas', 'Activo', 'clave4', 0, 'si', 'no', 0,0),
('D005', 'Andrés', 'Navarro', 'Activo', 'clave5', 1, 'si', 'no', 0,0),
('D006', 'Carolina', 'Reyes', 'Activo', 'clave6', 0, 'si', 'no', 1,0),
('D007', 'Sergio', 'Flores', 'Activo', 'clave7', 1, 'si', 'no', 0,0),
('D008', 'Paola', 'Campos', 'Activo', 'clave8', 0, 'si', 'no', 0,0),
('D009', 'Esteban', 'Mendoza', 'Activo', 'clave9', 1, 'si', 'no', 0,0),
('D010', 'Gabriela', 'Salazar', 'Activo', 'clave10', 0, 'si', 'no', 0,0);

-- ========================
-- Inserts para tabla: cargatrabajo
-- ========================
INSERT INTO cargatrabajo (descripcion, horas, periodo) VALUES
('Matemáticas I', 4, '2025-1'),
('Programación I', 6, '2025-1'),
('Inglés I', 3, '2025-1'),
('Física I', 5, '2025-1'),
('Química I', 4, '2025-1'),
('Historia', 2, '2025-1'),
('Educación Física', 2, '2025-1'),
('Bases de Datos', 5, '2025-2'),
('Programación II', 6, '2025-2'),
('Estadística', 4, '2025-2');

-- ========================
-- Inserts para tabla: inasistencia
-- ========================
INSERT INTO inasistencia (fk_carnetalum, fk_carnetdoc, fk_cargadecarrera, fechafalta, cantidadHoras, materia) VALUES
(1, 1, 1, '2025-01-15', 2, 'Matemáticas I'),
(2, 2, 2, '2025-01-16', 1, 'Programación I'),
(3, 3, 3, '2025-01-17', 3, 'Inglés I'),
(4, 4, 4, '2025-01-18', 2, 'Física I'),
(5, 5, 5, '2025-01-19', 1, 'Química I');

-- ========================
-- Inserts para tabla: alumnos_extra
-- ========================
INSERT INTO alumnos_extra (fk_alumno, motivo, observacion, tel_fijo, correopersonal, ciclo_academico, anio) VALUES
(1, 'Problemas de salud', 'Recuperación lenta', '2222-1111', 'juan@gmail.com', 'I', 2025),
(2, 'Trabajo', 'Doble turno', '2222-2222', 'maria@gmail.com', 'I', 2025),
(3, 'Familiar', 'Cuidado de un familiar', '2222-3333', 'carlos@gmail.com', 'I', 2025),
(4, 'Transporte', 'Vive lejos', '2222-4444', 'ana@gmail.com', 'I', 2025),
(5, 'Salud', 'Asma', '2222-5555', 'luis@gmail.com', 'I', 2025);
-- ========================
-- Inserts para tabla: seguimientos
-- ========================
INSERT INTO seguimientos (fk_id_alumno, fecha, accion, respuesta) VALUES
(1, '2025-02-01', 'Llamada de seguimiento', 'Alumno respondió, se compromete a mejorar'),
(2, '2025-02-02', 'Correo enviado', 'Sin respuesta'),
(3, '2025-02-03', 'Reunión presencial', 'Padres se comprometen a apoyar'),
(4, '2025-02-04', 'Visita domiciliaria', 'Alumno motivado a retomar clases'),
(5, '2025-02-05', 'Mensaje WhatsApp', 'Alumno confirma asistencia próxima');
