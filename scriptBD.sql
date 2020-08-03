--1. crear BD
CREATE DATABASE IF NOT EXISTS BDClaseVirtual
--2. Crear Tabla Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
			usuarioID INT NOT NULL AUTO_INCREMENT,
			nombreUsuario VARCHAR(30) NOT NULL,
			usuarioApellido  VARCHAR(30) NOT NULL,
			usuarioApodo     VARCHAR(50) NOT NULL,
			usuarioContra VARCHAR(50) NOT NULL,
			usuarioTipo 	 VARCHAR(13) NOT NULL,
			usuarioActivo   BOOLEAN NOT NULL,
			PRIMARY KEY (usuarioID)
			)
--3. Crear administrador  
INSERT INTO usuarios (nombreUsuario, usuarioApellido, usuarioApodo, usuarioContra, usuarioTipo, usuarioActivo)
				VALUES ('Admini', 'Admini', 'admin', 'password', 'administrador', 1)
--4. Las demás tablas pueden ser creadas a través del sitio web iniciando sesion como administrador, en el apartado de crear tablas.