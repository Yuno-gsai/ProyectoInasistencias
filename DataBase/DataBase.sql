-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS control_inasistencias;
USE control_inasistencias;

-- ========================
-- Tabla: Alumnos
-- ========================
CREATE TABLE alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carnet VARCHAR(50) NOT NULL UNIQUE,
    apell VARCHAR(100) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    becado TINYINT(1) DEFAULT 0,   -- 0 = no becado, 1 = becado
    tipobeca VARCHAR(100),
    estado VARCHAR(50)             -- activo, inactivo, suspendido, etc.
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
    esadminbecas TINYINT(1) DEFAULT 0
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
    FOREIGN KEY (fk_carnetalum) REFERENCES alumnos(id),
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
-- Tabla: AlumnosExtra
-- ========================
CREATE TABLE alumnos_extra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fk_alumnos INT NOT NULL,
    motivo VARCHAR(255),
    observacion TEXT,
    tel_fijo VARCHAR(20),
    celular VARCHAR(20),
    correoitca VARCHAR(100),
    correopersonal VARCHAR(100),
    ciclo_academico VARCHAR(50),
    anio INT,
    FOREIGN KEY (fk_alumnos) REFERENCES alumnos(id)
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
    FOREIGN KEY (fk_id_alumno) REFERENCES alumnos(id)
);


-- ========================
-- Inserts para tabla: alumnos
-- ========================
INSERT INTO alumnos (carnet, apell, nom, becado, tipobeca, estado) VALUES
('A001', 'Gómez', 'Juan', 1, 'Parcial', 'activo'),
('A002', 'López', 'María', 0, NULL, 'activo'),
('A003', 'Martínez', 'Carlos', 1, 'Completa', 'activo'),
('A004', 'Pérez', 'Ana', 0, NULL, 'activo'),
('A005', 'Rodríguez', 'Luis', 1, 'Parcial', 'activo'),
('A006', 'Sánchez', 'Carmen', 0, NULL, 'activo'),
('A007', 'Fernández', 'Jorge', 1, 'Completa', 'activo'),
('A008', 'Hernández', 'Lucía', 0, NULL, 'activo'),
('A009', 'Ramírez', 'Pedro', 1, 'Parcial', 'activo'),
('A010', 'Torres', 'Elena', 0, NULL, 'activo');

-- ========================
-- Inserts para tabla: docente
-- ========================
INSERT INTO docente (carnet, nom_usuario, ape_usuario, estado, clave, permanente, accesosistemas, cambio, esadminbecas) VALUES
('D001', 'José', 'Morales', 'activo', 'clave1', 1, 'si', 'no', 1),
('D002', 'Marta', 'Jiménez', 'activo', 'clave2', 0, 'si', 'no', 0),
('D003', 'Pablo', 'Castro', 'activo', 'clave3', 1, 'si', 'no', 0),
('D004', 'Lucía', 'Vargas', 'activo', 'clave4', 0, 'si', 'no', 0),
('D005', 'Andrés', 'Navarro', 'activo', 'clave5', 1, 'si', 'no', 0),
('D006', 'Carolina', 'Reyes', 'activo', 'clave6', 0, 'si', 'no', 1),
('D007', 'Sergio', 'Flores', 'activo', 'clave7', 1, 'si', 'no', 0),
('D008', 'Paola', 'Campos', 'activo', 'clave8', 0, 'si', 'no', 0),
('D009', 'Esteban', 'Mendoza', 'activo', 'clave9', 1, 'si', 'no', 0),
('D010', 'Gabriela', 'Salazar', 'activo', 'clave10', 0, 'si', 'no', 0);

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
(5, 5, 5, '2025-01-19', 1, 'Química I'),
(6, 6, 6, '2025-01-20', 2, 'Historia'),
(7, 7, 7, '2025-01-21', 1, 'Educación Física'),
(8, 8, 8, '2025-01-22', 3, 'Bases de Datos'),
(9, 9, 9, '2025-01-23', 2, 'Programación II'),
(10, 10, 10, '2025-01-24', 1, 'Estadística');

-- ========================
-- Inserts para tabla: alumnos_extra
-- ========================
INSERT INTO alumnos_extra (fk_alumnos, motivo, observacion, tel_fijo, celular, correoitca, correopersonal, ciclo_academico, anio) VALUES
(1, 'Problemas de salud', 'Recuperación lenta', '2222-1111', '7777-1111', 'juan@itca.edu.sv', 'juan@gmail.com', 'I', 2025),
(2, 'Trabajo', 'Doble turno', '2222-2222', '7777-2222', 'maria@itca.edu.sv', 'maria@gmail.com', 'I', 2025),
(3, 'Familiar', 'Cuidado de un familiar', '2222-3333', '7777-3333', 'carlos@itca.edu.sv', 'carlos@gmail.com', 'I', 2025),
(4, 'Transporte', 'Vive lejos', '2222-4444', '7777-4444', 'ana@itca.edu.sv', 'ana@gmail.com', 'I', 2025),
(5, 'Salud', 'Asma', '2222-5555', '7777-5555', 'luis@itca.edu.sv', 'luis@gmail.com', 'I', 2025),
(6, 'Trabajo', 'Horario nocturno', '2222-6666', '7777-6666', 'carmen@itca.edu.sv', 'carmen@gmail.com', 'I', 2025),
(7, 'Familiar', 'Hijo enfermo', '2222-7777', '7777-7777', 'jorge@itca.edu.sv', 'jorge@gmail.com', 'I', 2025),
(8, 'Económico', 'Falta de recursos', '2222-8888', '7777-8888', 'lucia@itca.edu.sv', 'lucia@gmail.com', 'I', 2025),
(9, 'Trabajo', 'Cambio de turno', '2222-9999', '7777-9999', 'pedro@itca.edu.sv', 'pedro@gmail.com', 'I', 2025),
(10, 'Otro', 'Falta de motivación', '2333-0000', '7888-0000', 'elena@itca.edu.sv', 'elena@gmail.com', 'I', 2025);

-- ========================
-- Inserts para tabla: seguimientos
-- ========================
INSERT INTO seguimientos (fk_id_alumno, fecha, accion, respuesta) VALUES
(1, '2025-02-01', 'Llamada de seguimiento', 'Alumno respondió, se compromete a mejorar'),
(2, '2025-02-02', 'Correo enviado', 'Sin respuesta'),
(3, '2025-02-03', 'Reunión presencial', 'Padres se comprometen a apoyar'),
(4, '2025-02-04', 'Visita domiciliaria', 'Alumno motivado a retomar clases'),
(5, '2025-02-05', 'Mensaje WhatsApp', 'Alumno confirma asistencia próxima'),
(6, '2025-02-06', 'Llamada de seguimiento', 'No contestó'),
(7, '2025-02-07', 'Correo enviado', 'Alumno respondió positivamente'),
(8, '2025-02-08', 'Reunión presencial', 'Se evaluó plan de apoyo académico'),
(9, '2025-02-09', 'Llamada de seguimiento', 'Alumno pide más tiempo'),
(10, '2025-02-10', 'Mensaje WhatsApp', 'Alumno agradece seguimiento');
