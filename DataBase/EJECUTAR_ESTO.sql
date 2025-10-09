-- =====================================
-- IMPORTANTE: Ejecutar este script
-- =====================================

-- Agregar campos para justificaciones
ALTER TABLE inasistencia 
ADD COLUMN justificacion_texto TEXT AFTER observacion,
ADD COLUMN justificacion_imagen VARCHAR(255) AFTER justificacion_texto,
ADD COLUMN tiene_justificacion TINYINT(1) DEFAULT 0 AFTER justificacion_imagen;

-- Verificar que se agregaron correctamente
DESCRIBE inasistencia;

-- Actualizar el campo justificando si ya existe (mantener compatibilidad)
-- Si no existe, se crea
ALTER TABLE inasistencia 
MODIFY COLUMN justificando TINYINT(1) DEFAULT 0;

-- Crear carpeta para imágenes (esto debe hacerse manualmente en el servidor)
-- mkdir -p /opt/lampp/htdocs/ProyectoInasistencias/uploads/justificaciones
-- chmod 755 /opt/lampp/htdocs/ProyectoInasistencias/uploads/justificaciones