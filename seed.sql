USE control_asistencias_qr;


INSERT INTO empresas (id, nombre, email) 
VALUES (1, 'Empresa de Prueba CI/CD', 'test@ci.com')
ON DUPLICATE KEY UPDATE id=id;

INSERT INTO empleados (id, numero_empleado, nombre, apellido_paterno, qr_token, activo, empresa_id) 
VALUES (1, 'EMP-001', 'Juan', 'Reynoso', 'TOKEN_DE_PRUEBA_123', 1, 1)
ON DUPLICATE KEY UPDATE id=id;


INSERT INTO asistencias (id, empleado_id, fecha, hora_entrada, retardo)
VALUES (1, 1, '2026-01-01', '08:00:00', 0)
ON DUPLICATE KEY UPDATE id=id;
