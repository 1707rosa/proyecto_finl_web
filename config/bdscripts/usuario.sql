
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255),
    proveedor_oauth VARCHAR(50),
    oauth_id VARCHAR(255),
    rol ENUM('reportero', 'validador', 'admin') DEFAULT 'reportero',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nombre, email, password, rol)
VALUES (
    'Berlyng',
    'berlyng@example.com',
    '$2y$12$2JrC6cUfpTkVWjyu5f3qPeq.tE/XCb5NX7h9aGrnql0FgNA77RvZe',
    'admin'
);

select * from usuarios;
