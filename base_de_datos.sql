Create database if not exists colegio_nh;
use colegio_nh;


-- Creación de la tabla Usuarios
-- ==========================================
-- TABLAS CATÁLOGO (Normalización)
-- ==========================================

CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) UNIQUE NOT NULL -- Ej: 'Estudiante', 'Profesor', 'Administrador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE grados (
    id_grado INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grado VARCHAR(50) UNIQUE NOT NULL -- Ej: '1ro Básico', '6to Primaria'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE autores (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(150) UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- MÓDULO DE USUARIOS
-- ==========================================

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    id_rol INT NOT NULL,
    id_grado INT NULL, -- NULL si es un Administrador que no pertenece a un grado específico
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    CONSTRAINT fk_usuario_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON UPDATE CASCADE,
    CONSTRAINT fk_usuario_grado FOREIGN KEY (id_grado) REFERENCES grados(id_grado) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- MÓDULO DE BIBLIOTECA
-- ==========================================

CREATE TABLE catalogo_libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    id_grado INT NULL, -- Para recomendarlo a un grado escolar específico
    CONSTRAINT fk_libro_grado FOREIGN KEY (id_grado) REFERENCES grados(id_grado) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla pivote para relación Muchos a Muchos (Libros <-> Autores)
CREATE TABLE libros_autores (
    id_libro INT NOT NULL,
    id_autor INT NOT NULL,
    PRIMARY KEY (id_libro, id_autor),
    CONSTRAINT fk_pivot_libro FOREIGN KEY (id_libro) REFERENCES catalogo_libros(id_libro) ON DELETE CASCADE,
    CONSTRAINT fk_pivot_autor FOREIGN KEY (id_autor) REFERENCES autores(id_autor) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ejemplares_fisicos (
    id_ejemplar INT AUTO_INCREMENT PRIMARY KEY,
    id_libro INT NOT NULL,
    codigo_interno VARCHAR(50) UNIQUE NOT NULL,
    disponibilidad BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_ejemplar_libro FOREIGN KEY (id_libro) REFERENCES catalogo_libros(id_libro) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE prestamos (
    id_prestamo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_ejemplar INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE,
    CONSTRAINT fk_prestamo_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    CONSTRAINT fk_prestamo_ejemplar FOREIGN KEY (id_ejemplar) REFERENCES ejemplares_fisicos(id_ejemplar) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- MÓDULO DE ASISTENCIAS
-- ==========================================

CREATE TABLE asistencias (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha DATE NOT NULL,
    hora_registro TIME NOT NULL,
    estado ENUM('Presente', 'Ausente', 'Tarde', 'Justificado') NOT NULL DEFAULT 'Presente',
    observaciones VARCHAR(255) NULL,
    CONSTRAINT fk_asistencia_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE justificaciones (
    id_justificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_asistencia INT NOT NULL,
    motivo TEXT NOT NULL,
    archivo_adjunto VARCHAR(255) NULL,
    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_justificacion_asistencia FOREIGN KEY (id_asistencia) REFERENCES asistencias(id_asistencia) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;