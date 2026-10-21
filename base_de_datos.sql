
Create database if not exists biblioteca_nh;
use biblioteca_nh;


-- Creación de la tabla Usuarios
CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    rol VARCHAR(50) NOT NULL,
    grado_asignado VARCHAR(50),
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creación de la tabla catalogo_libros
CREATE TABLE catalogo_libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    autor VARCHAR(150) NOT NULL,
    grado_escolar VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creación de la tabla ejemplares_fisicos
-- Se crea después de catalogo_libros porque tiene una llave foránea que depende de ella
CREATE TABLE ejemplares_fisicos (
    id_ejemplar INT AUTO_INCREMENT PRIMARY KEY,
    id_libro INT NOT NULL,
    codigo_interno VARCHAR(50) UNIQUE NOT NULL,
    disponibilidad BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_ejemplar_libro FOREIGN KEY (id_libro) 
        REFERENCES catalogo_libros(id_libro) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creación de la tabla prestamos
-- Se crea de último porque depende de Usuarios y ejemplares_fisicos
CREATE TABLE prestamos (
    id_prestamo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_ejemplar INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE,
    CONSTRAINT fk_prestamo_usuario FOREIGN KEY (id_usuario) 
        REFERENCES Usuarios(id_usuario) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_prestamo_ejemplar FOREIGN KEY (id_ejemplar) 
        REFERENCES ejemplares_fisicos(id_ejemplar) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;