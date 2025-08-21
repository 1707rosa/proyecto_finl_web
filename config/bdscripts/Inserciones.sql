

------- Inserciones -------------------------------------------
INSERT INTO usuarios (nombre, email, contraseña, rol)
VALUES (
    'Berlyng',
    'berlyng@example.com',
    '$2y$12$2JrC6cUfpTkVWjyu5f3qPeq.tE/XCb5NX7h9aGrnql0FgNA77RvZe',
    'admin'
);

INSERT INTO Tipos_incidencias (id, nombre) VALUES
(1, 'Accidente'),
(2, 'Desastre Natural'),
(3, 'Robo'),
(4, 'Pelea'),
(5, 'Incendio');

INSERT INTO Provincias (nombre) VALUES
('Santo Domingo'),
('Santiago'),
('La Vega'),
('Monseñor Nouel');

INSERT INTO Municipios (nombre, provincia_id) VALUES
('Distrito Nacional', 1),
('Los Alcarrizos', 1),
('Santiago', 2),
('La Vega', 3),
('Bonao', 4);

INSERT INTO Barrios (nombre, municipio_id) VALUES
('Centro', 1),
('Villa Linda', 2),
('Centro Histórico', 3),
('Zona Industrial', 4),
('Carretera Montaña', 5);


INSERT INTO Incidencias 
(titulo, descripcion, fecha, muertos, heridos, perdida_estimada_de_RD, redes_link, foto, latitud, longitud, provincia_id, municipio_id, barrio_id, usuario_id, tipo_id)
VALUES
('Accidente en Autopista Duarte', 'Choque múltiple durante las horas pico entre 3 vehículos', '2024-12-15', 0, 3, 500000.00, NULL, NULL, 18.48000000, -69.94000000, 1, 1, 1, 1, 1),
('Inundación en Los Alcarrizos', 'Desbordamiento del río Ozama tras lluvias intensas', '2024-12-14', 0, 0, 1000000.00, NULL, NULL, 18.53000000, -70.03000000, 1, 2, 2, 1, 2),
('Robo en supermercado', 'Asalto a mano armada en horario nocturno', '2024-12-13', 0, 1, 20000.00, NULL, NULL, 19.45000000, -70.69000000, 2, 3, 3, 1, 3),
('Pelea en centro comercial', 'Altercado entre grupos de jóvenes', '2024-12-12', 0, 2, 0.00, NULL, NULL, 18.50000000, -69.90000000, 1, 1, 1, 1, 4),
('Incendio en fábrica', 'Incendio controlado sin heridos', '2024-12-11', 0, 0, 250000.00, NULL, NULL, 19.23000000, -70.53000000, 3, 4, 4, 1, 5),
('Deslizamiento de tierra', 'Deslizamiento en carretera de montaña', '2024-12-10', 2, 5, 750000.00, NULL, NULL, 18.94000000, -70.41000000, 4, 5, 5, 1, 2);
