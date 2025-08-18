-- Datos de prueba para la parte de Emil (lista y filtros)
-- Usar la base de datos existente
USE proyectofinalweb;

-- Insertar incidencias de prueba para probar filtros y lista
INSERT IGNORE INTO incidencias (titulo, descripcion, provincia, municipio, tipo, fecha, usuario_id) VALUES 
('Accidente en Autopista Duarte', 'Choque múltiple durante las horas pico entre 3 vehículos', 'Santo Domingo', 'Distrito Nacional', 'Accidente', '2024-12-15', 1),
('Inundación en Los Alcarrizos', 'Desbordamiento del río Ozama tras lluvias intensas', 'Santo Domingo', 'Los Alcarrizos', 'Desastre Natural', '2024-12-14', 1),
('Robo en supermercado', 'Asalto a mano armada en horario nocturno', 'Santiago', 'Santiago', 'Robo', '2024-12-13', 1),
('Pelea en centro comercial', 'Altercado entre grupos de jóvenes', 'Santo Domingo', 'Santiago', 'Pelea', '2024-12-12', 1),
('Incendio en fábrica', 'Incendio controlado sin heridos', 'La Vega', 'La Vega', 'Accidente', '2024-12-11', 1),
('Deslizamiento de tierra', 'Deslizamiento en carretera de montaña', 'Monseñor Nouel', 'Bonao', 'Desastre Natural', '2024-12-10', 1);