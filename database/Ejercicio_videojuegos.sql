-- Consigna: La tienda "Game Galaxy" quiere modernizar su sistema de gestión. Necesitan una base
-- de datos para registrar la siguiente información:
-- • Videojuegos: Cada videojuego tiene un nombre, una plataforma (PC, PlayStation, Xbox,
-- etc.), una categoría (Acción, RPG, Estrategia), un precio y el nombre del desarrollador.
-- • Clientes: Se debe registrar el nombre completo, el correo electrónico y la fecha de
-- nacimiento de cada cliente.
-- • Ventas: Cada venta debe registrar la fecha en que se realizó, el cliente que compró y los
-- videojuegos que se incluyeron en la compra, así como la cantidad de cada uno.

CREATE DATABASE Game_Galaxy;

USE Game_Galaxy;

CREATE TABLE plataformas (
    id_plat INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) UNIQUE,
    fec_alta DATE,
    fec_modi DATE,
    fec_baja DATE
);

CREATE TABLE categorias (
    id_cat INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) UNIQUE,
    fec_alta DATE,
    fec_modi DATE,
    fec_baja DATE
);

CREATE TABLE requisitos (
    id_req INT AUTO_INCREMENT PRIMARY KEY,
    arquitect VARCHAR(60),
    proc_min VARCHAR(120),
    proc_max VARCHAR(120),
    ram_min VARCHAR(60),
    ram_max VARCHAR(60),
    grafica_min VARCHAR(120),
    grafica_max VARCHAR(120),
    directx VARCHAR(20)
);

CREATE TABLE videojuegos (
    id_vid INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) UNIQUE,
    precio DECIMAL(10, 2),
    desarrollador VARCHAR(60),
    formato VARCHAR(10) CHECK (
        formato IN ('Digital', 'Físico')
    ),
    microtran BOOLEAN,
    requisitos INT,
    lanzamiento DATE,
    fec_alta DATE,
    fec_modi DATE,
    fec_baja DATE,
    stock INT DEFAULT 0,
    imagen varchar(120),
    destacado bool DEFAULT False,
    FOREIGN KEY (requisitos) REFERENCES requisitos (id_req)
);

CREATE TABLE videojuegos_plataformas (
    id_vid_plat INT AUTO_INCREMENT PRIMARY KEY,
    videojuego_id INT NOT NULL,
    plataforma_id INT NOT NULL,
    FOREIGN KEY (videojuego_id) REFERENCES videojuegos (id_vid),
    FOREIGN KEY (plataforma_id) REFERENCES plataformas (id_plat),
    UNIQUE (videojuego_id, plataforma_id)
);

CREATE TABLE videojuegos_categorias (
    id_vid_cat INT AUTO_INCREMENT PRIMARY KEY,
    videojuego_id INT NOT NULL,
    categoria_id INT NOT NULL,
    FOREIGN KEY (videojuego_id) REFERENCES videojuegos (id_vid),
    FOREIGN KEY (categoria_id) REFERENCES categorias (id_cat),
    UNIQUE (videojuego_id, categoria_id)
);

CREATE TABLE clientes (
    dni INT UNIQUE PRIMARY KEY,
    nombre VARCHAR(40),
    apellido VARCHAR(40),
    fecha_nac DATE,
    email VARCHAR(60) UNIQUE
);

CREATE TABLE ventas_cabecera (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    cliente INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (cliente) REFERENCES clientes (dni)
);

CREATE TABLE ventas_detalle (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    videojuego_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES ventas_cabecera (id_venta),
    FOREIGN KEY (videojuego_id) REFERENCES videojuegos (id_vid)
);

-- drop database Game_Galaxy;

-- DML Data Manipulation Language | Lenguaje de manipulación de datos
-- Inserción de datos a cada tabla

INSERT INTO
    plataformas (nombre, fec_alta)
VALUES ('PC', '2023-01-10'),
    ('PlayStation 5', '2023-01-10'),
    ('Xbox Series X', '2023-01-10'),
    (
        'Nintendo Switch',
        '2023-01-10'
    ),
    (
        'Móvil (Android/iOS)',
        '2023-01-10'
    );

INSERT INTO
    categorias (nombre, fec_alta)
VALUES ('RPG', '2023-01-10'),
    ('FPS', '2023-01-10'),
    ('Estrategia', '2023-01-10'),
    ('Deportes', '2023-01-10'),
    (
        'Aventura Gráfica',
        '2023-01-10'
    );

INSERT INTO
    requisitos (
        id_req,
        arquitect,
        proc_min,
        proc_max,
        ram_min,
        ram_max,
        grafica_min,
        grafica_max,
        directx
    )
VALUES (
        1,
        'x64',
        'Intel Core i5',
        'Intel Core i7',
        '8GB',
        '16GB',
        'GTX 1060',
        'RTX 3060',
        'DX 12'
    ),
    (
        2,
        'x64',
        'AMD Ryzen 5',
        'AMD Ryzen 7',
        '16GB',
        '32GB',
        'RX 580',
        'RX 6700',
        'DX 12'
    ),
    (
        3,
        'x64',
        'Intel i3',
        'Intel i5',
        '4GB',
        '8GB',
        'GTX 750',
        'GTX 1050',
        'DX 11'
    ),
    (
        4,
        'x64',
        'AMD FX-4300',
        'AMD Ryzen 3',
        '6GB',
        '12GB',
        'Radeon HD 7770',
        'Radeon RX 570',
        'DX 11'
    ),
    (
        5,
        'n/a',
        'n/a',
        'n/a',
        'n/a',
        'n/a',
        'n/a',
        'n/a',
        'n/a'
    );

INSERT INTO
    videojuegos (
        id_vid,
        titulo,
        precio,
        desarrollador,
        formato,
        microtran,
        requisitos,
        lanzamiento,
        fec_alta,
        stock,
        imagen,
        destacado
    )
VALUES (
        101,
        'Cyberpunk 2077',
        59.99,
        'CD Projekt Red',
        'Digital',
        TRUE,
        1,
        '2020-12-10',
        '2023-10-25',
        500,
        "img/cyberpunk_cover.jpg",
        true
    ),
    (
        102,
        'Starcraft II',
        39.99,
        'Blizzard',
        'Digital',
        FALSE,
        3,
        '2010-07-27',
        '2023-10-25',
        1200,
        "img/starcatfii.webp",
        false
    ),
    (
        103,
        'Elden Ring',
        69.99,
        'FromSoftware',
        'Físico',
        FALSE,
        2,
        '2022-02-25',
        '2023-10-25',
        300,
        "img/eldenring_cover.jpg",
        true
    ),
    (
        104,
        'FIFA 25',
        79.99,
        'EA Sports',
        'Digital',
        TRUE,
        1,
        '2024-09-15',
        '2023-10-25',
        800,
        "img/fc25.webp",
        true
    ),
    (
        105,
        'Candy Crush Saga',
        0.00,
        'King',
        'Digital',
        TRUE,
        5,
        '2012-04-12',
        '2023-10-25',
        9999,
        "img/candycrush.jpg",
        false
    );

INSERT INTO
    videojuegos_plataformas (videojuego_id, plataforma_id)
VALUES (101, 1),
    (101, 2),
    (101, 3),
    (102, 1),
    (103, 1),
    (103, 2),
    (103, 3),
    (104, 1),
    (104, 2),
    (104, 3),
    (104, 4),
    (105, 5);

INSERT INTO
    videojuegos_categorias (videojuego_id, categoria_id)
VALUES (101, 1),
    (102, 3),
    (103, 1),
    (104, 4),
    (105, 5);

INSERT INTO
    videojuegos_categorias (videojuego_id, categoria_id) values (105,2);

INSERT INTO
    clientes (
        dni,
        nombre,
        apellido,
        fecha_nac,
        email
    )
VALUES (
        12345678,
        'Juan',
        'Perez',
        '1990-05-15',
        'juan.perez@example.com'
    ),
    (
        23456789,
        'Maria',
        'Gomez',
        '1985-11-20',
        'maria.gomez@example.com'
    ),
    (
        34567890,
        'Carlos',
        'Lopez',
        '2000-01-01',
        'carlos.lopez@example.com'
    ),
    (
        45678901,
        'Laura',
        'Diaz',
        '1998-07-28',
        'laura.diaz@example.com'
    ),
    (
        56789012,
        'Pedro',
        'Ruiz',
        '1975-03-10',
        'pedro.ruiz@example.com'
    );

INSERT INTO
    ventas_cabecera (
        id_venta,
        fecha,
        cliente,
        total
    )
VALUES (
        1,
        '2024-10-25 10:00:00',
        12345678,
        139.98
    ),
    (
        2,
        '2024-10-25 11:30:00',
        23456789,
        139.98
    ),
    (
        3,
        '2024-10-25 14:00:00',
        34567890,
        39.99
    ),
    (
        4,
        '2024-10-26 09:15:00',
        45678901,
        129.98
    ),
    (
        5,
        '2024-10-26 15:20:00',
        56789012,
        239.97
    );

INSERT INTO
    ventas_detalle (
        venta_id,
        videojuego_id,
        cantidad,
        precio_unitario,
        subtotal
    )
VALUES (1, 101, 1, 59.99, 59.99),
    (1, 104, 1, 79.99, 79.99),
    (2, 103, 2, 69.99, 139.98),
    (3, 102, 1, 39.99, 39.99),
    (4, 101, 1, 59.99, 59.99),
    (4, 103, 1, 69.99, 69.99),
    (5, 104, 3, 79.99, 239.97);

-- Validación de datos cargados

SELECT * FROM plataformas;

SELECT * FROM categorias;

SELECT * FROM requisitos;

SELECT * FROM clientes;

SELECT * FROM videojuegos;

SELECT * FROM videojuegos_plataformas;

SELECT * FROM videojuegos_categorias;

SELECT * FROM ventas_cabecera;

SELECT * FROM ventas_detalle;

SELECT v.titulo AS 'Videojuego', r.ram_min AS 'RAM Mínima', r.grafica_min AS 'Gráfica Mínima'
FROM videojuegos v
    INNER JOIN requisitos r ON v.requisitos = r.id_req;

SELECT v.titulo AS 'Videojuego'
FROM
    videojuegos v
    INNER JOIN videojuegos_plataformas vp ON v.id_vid = vp.videojuego_id
    INNER JOIN plataformas p ON vp.plataforma_id = p.id_plat
WHERE
    p.nombre = 'PlayStation 5';

SELECT vc.fecha AS 'Fecha de Venta', CONCAT(c.nombre, ' ', c.apellido) AS 'Nombre del Cliente', vc.total AS 'Monto Total'
FROM
    ventas_cabecera vc
    INNER JOIN clientes c ON vc.cliente = c.dni
ORDER BY vc.fecha DESC;

SELECT v.titulo AS 'Videojuego Vendido', vd.cantidad AS 'Cantidad'
FROM
    ventas_detalle vd
    INNER JOIN videojuegos v ON vd.videojuego_id = v.id_vid
WHERE
    vd.venta_id = 4;

SELECT cat.nombre AS 'Categoría', v.titulo AS 'Videojuego', SUM(vd.cantidad) AS 'Unidades Totales Vendidas'
FROM
    categorias cat
    INNER JOIN videojuegos_categorias vc ON cat.id_cat = vc.categoria_id
    INNER JOIN videojuegos v ON vc.videojuego_id = v.id_vid
    LEFT JOIN ventas_detalle vd ON v.id_vid = vd.videojuego_id
WHERE
    cat.nombre = 'RPG'
GROUP BY
    v.titulo,
    cat.nombre
ORDER BY 'Unidades Totales Vendidas' DESC;

--- Selects para los modelos
-- Datos para el index
SELECT v.id_vid, v.titulo, v.precio, cat.nombre, v.imagen
FROM
    categorias cat
    INNER JOIN videojuegos_categorias vc ON cat.id_cat = vc.categoria_id
    INNER JOIN videojuegos v ON vc.videojuego_id = v.id_vid;

use Game_Galaxy;

select * from videojuegos;

SELECT v.id_vid, v.titulo, v.precio, v.imagen, cat.nombre FROM categorias cat INNER JOIN videojuegos_categorias vc ON cat.id_cat = vc.categoria_id INNER JOIN videojuegos v ON vc.videojuego_id = v.id_vid;

SELECT
    cat.nombre 
FROM
    categorias cat
INNER JOIN
    videojuegos_categorias vc ON cat.id_cat = vc.categoria_id
WHERE
    vc.videojuego_id = 105;

