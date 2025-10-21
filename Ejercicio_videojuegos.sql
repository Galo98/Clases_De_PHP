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
	id_plat int unique auto_increment primary key,
    nombre varchar (30)
);

CREATE TABLE categorias (
	id_cat int unique auto_increment primary key,
    nombre varchar (30)
);

CREATE TABLE videojuegos (
	id_vid int unique,
	titulo varchar (50),
    plataforma int unique,
    categoria int unique,
    precio float(10,2),
    desarrollador varchar (60),
    foreign key (plataforma) references plataformas (id_plat),
    foreign key (categoria) references categorias (id_cat)
);

CREATE TABLE clientes (
	dni int unique primary key,
    nombre varchar (40),
    apellido varchar(40),
    fecha_nac date,
    email varchar(60)
);

CREATE TABLE ventas_detalle (
	id_detalle int primary key,
    videojuego int,
    cantidad int(2),
    foreign key (videojuego) references videojuegos (id_vid)
);

CREATE TABLE ventas_cabecera	(
	venta int unique primary key,
    fecha date,
    cliente int,
    detalle int,
    foreign key (cliente) references clientes (dni),
    foreign key (detalle) references ventas_detalle(id_detalle)
);

-- drop database Game_Galaxy;

-- DML Data Manipulation Language | Lenguaje de manipulación de datos

INSERT INTO plataformas (nombre) 
VALUES 
("PC"), 
("XBOX 360"),
("XBOX ONE"),
("XBOX S"), ("XBOX X"), 
("PLAY STATION 1"),("PLAY STATION 2"),("PLAY STATION 3"),("PLAY STATION 4"),
("PLAY STATION 5"),
("NINTENDO SWITCH"),("WII"),("WII U");

