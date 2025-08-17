CREATE DATABASE IF NOT EXISTS incidencias_provisional_idelka;
USE incidencias_provisional_idelka;

CREATE TABLE IF NOT EXISTS incidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    provincia VARCHAR(100) NOT NULL,
    municipio VARCHAR(100) NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    usuario_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
