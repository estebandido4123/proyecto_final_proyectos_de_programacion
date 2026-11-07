<?php namespace App\Controllers;

use CodeIgniter\Controller;

class ProfesorController extends BaseController
{
    public function index()
    {
        $session = session();
        
        // Verificar sesión y rol de profesor (id_rol = 3)
        if (!$session->get('logged_in') || $session->get('id_rol') != 3) {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado');
        }

        $db = \Config\Database::connect();

        // 1. Obtener catálogo de libros con sus autores y grados correspondientes
        $queryLibros = $db->query("
            SELECT l.id_libro, l.titulo, g.nombre_grado, GROUP_CONCAT(a.nombre_completo SEPARATOR ', ') AS autores
            FROM catalogo_libros l
            LEFT JOIN grados g ON l.id_grado = g.id_grado
            LEFT JOIN libros_autores la ON l.id_libro = la.id_libro
            LEFT JOIN autores a ON la.id_autor = a.id_autor
            GROUP BY l.id_libro
        ");
        $libros = $queryLibros->getResultArray();

        // 2. Asociar a cada libro la disponibilidad de sus ejemplares físicos y préstamos activos
        foreach ($libros as &$libro) {
            // Obtener el primer ejemplar disponible (disponibilidad = 1)
            $ejemplarDisponible = $db->table('ejemplares_fisicos')
                ->where('id_libro', $libro['id_libro'])
                ->where('disponibilidad', 1)
                ->get()
                ->getFirstRow('array');

            $libro['disponible'] = $ejemplarDisponible ? true : false;
            $libro['id_ejemplar_disponible'] = $ejemplarDisponible ? $ejemplarDisponible['id_ejemplar'] : null;

            // Obtener lista de préstamos activos (sin fecha de devolución)
            $queryPrestamos = $db->query("
                SELECT p.id_prestamo, p.fecha_prestamo, u.nombres, u.apellidos, ef.codigo_interno
                FROM prestamos p
                JOIN ejemplares_fisicos ef ON p.id_ejemplar = ef.id_ejemplar
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                WHERE ef.id_libro = ? AND p.fecha_devolucion IS NULL
            ", [$libro['id_libro']]);
            
            $libro['prestamos_activos'] = $queryPrestamos->getResultArray();
        }

        // 3. Obtener listado de estudiantes (id_rol = 2) y grados para los selectores
        $estudiantes = $db->table('usuarios')->where('id_rol', 2)->get()->getResultArray();
        $grados = $db->table('grados')->get()->getResultArray();

        $data = [
            'libros'      => $libros,
            'estudiantes' => $estudiantes,
            'grados'      => $grados
        ];

        return view('vista_profesor', $data);
    }

    public function asignarLibro()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('id_rol') != 3) {
            return redirect()->to(base_url('/'));
        }

        $id_ejemplar = $this->request->getPost('id_ejemplar');
        $id_usuario  = $this->request->getPost('id_usuario');
        $fecha_actual = date('Y-m-d');

        if (!$id_ejemplar || !$id_usuario) {
            return redirect()->to(base_url('profesor/inicio'))->with('error', 'Debe seleccionar un ejemplar y un estudiante válido.');
        }

        $db = \Config\Database::connect();

        // Insertar registro en la tabla de préstamos
        $db->table('prestamos')->insert([
            'id_usuario'     => $id_usuario,
            'id_ejemplar'    => $id_ejemplar,
            'fecha_prestamo' => $fecha_actual
        ]);

        // Actualizar disponibilidad del ejemplar a 0 (Prestado)
        $db->table('ejemplares_fisicos')
            ->where('id_ejemplar', $id_ejemplar)
            ->update(['disponibilidad' => 0]);

        return redirect()->to(base_url('profesor/inicio'))->with('mensaje', 'El libro ha sido asignado al estudiante con éxito.');
    }

    public function devolverLibro()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('id_rol') != 3) {
            return redirect()->to(base_url('/'));
        }

        $id_prestamo  = $this->request->getPost('id_prestamo');
        $fecha_actual = date('Y-m-d');

        $db = \Config\Database::connect();

        $prestamo = $db->table('prestamos')->where('id_prestamo', $id_prestamo)->get()->getRowArray();

        if ($prestamo) {
            // Marcar fecha de devolución
            $db->table('prestamos')
                ->where('id_prestamo', $id_prestamo)
                ->update(['fecha_devolucion' => $fecha_actual]);

            // Reactivar disponibilidad del ejemplar físico (1 = Disponible)
            $db->table('ejemplares_fisicos')
                ->where('id_ejemplar', $prestamo['id_ejemplar'])
                ->update(['disponibilidad' => 1]);

            return redirect()->to(base_url('profesor/inicio'))->with('mensaje', 'Devolución registrada correctamente.');
        }

        return redirect()->to(base_url('profesor/inicio'))->with('error', 'Ocurrió un error al procesar la devolución.');
    }
}