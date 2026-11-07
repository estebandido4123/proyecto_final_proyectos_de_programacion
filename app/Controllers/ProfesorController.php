<?php

namespace App\Controllers;

class ProfesorController extends BaseController
{
    private const ID_ROL_PROFESOR   = 3;
    private const ID_ROL_ESTUDIANTE = 2;

    /** Verifica sesión activa y rol de profesor */
    private function esProfesor(): bool
    {
        $session = session();
        return $session->get('logged_in') && $session->get('id_rol') == self::ID_ROL_PROFESOR;
    }

    public function index()
    {
        if (!$this->esProfesor()) {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado');
        }

        $db = \Config\Database::connect();

        // 1. Catálogo con autores y grado (incluye id_grado para el filtro)
        $libros = $db->query("
            SELECT l.id_libro, l.titulo, l.id_grado, g.nombre_grado,
                   GROUP_CONCAT(a.nombre_completo SEPARATOR ', ') AS autores
            FROM catalogo_libros l
            LEFT JOIN grados g ON l.id_grado = g.id_grado
            LEFT JOIN libros_autores la ON l.id_libro = la.id_libro
            LEFT JOIN autores a ON la.id_autor = a.id_autor
            GROUP BY l.id_libro, l.titulo, l.id_grado, g.nombre_grado
            ORDER BY l.titulo ASC
        ")->getResultArray();

        // 2. Un ejemplar disponible por libro (una sola consulta)
        $disp = $db->query("
            SELECT id_libro, MIN(id_ejemplar) AS id_ejemplar
            FROM ejemplares_fisicos
            WHERE disponibilidad = 1
            GROUP BY id_libro
        ")->getResultArray();
        $dispPorLibro = array_column($disp, 'id_ejemplar', 'id_libro');

        // 3. Préstamos activos de todos los libros (una sola consulta)
        $prestamos = $db->query("
            SELECT ef.id_libro, p.id_prestamo, p.fecha_prestamo,
                   u.nombres, u.apellidos, ef.codigo_interno
            FROM prestamos p
            JOIN ejemplares_fisicos ef ON p.id_ejemplar = ef.id_ejemplar
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            WHERE p.fecha_devolucion IS NULL
        ")->getResultArray();

        $prestamosPorLibro = [];
        foreach ($prestamos as $p) {
            $prestamosPorLibro[$p['id_libro']][] = $p;
        }

        foreach ($libros as &$libro) {
            $id = $libro['id_libro'];
            $libro['id_ejemplar_disponible'] = $dispPorLibro[$id] ?? null;
            $libro['disponible']             = isset($dispPorLibro[$id]);
            $libro['prestamos_activos']      = $prestamosPorLibro[$id] ?? [];
        }
        unset($libro);

        // 4. Estudiantes y grados para los selectores
        $estudiantes = $db->table('usuarios')
            ->where('id_rol', self::ID_ROL_ESTUDIANTE)
            ->orderBy('apellidos', 'ASC')
            ->get()->getResultArray();

        $grados = $db->table('grados')->get()->getResultArray();

        return view('vista_profesor', [
            'libros'      => $libros,
            'estudiantes' => $estudiantes,
            'grados'      => $grados,
        ]);
    }

    public function asignarLibro()
    {
        if (!$this->esProfesor()) {
            return redirect()->to(base_url('/'));
        }

        $id_ejemplar = $this->request->getPost('id_ejemplar');
        $id_usuario  = $this->request->getPost('id_usuario');

        if (!$id_ejemplar || !$id_usuario) {
            return redirect()->to(base_url('profesor/inicio'))
                ->with('error', 'Debe seleccionar un ejemplar y un estudiante válido.');
        }

        $db = \Config\Database::connect();

        // Verificar que el ejemplar siga disponible
        $ejemplar = $db->table('ejemplares_fisicos')
            ->where('id_ejemplar', $id_ejemplar)
            ->where('disponibilidad', 1)
            ->get()->getRowArray();

        if (!$ejemplar) {
            return redirect()->to(base_url('profesor/inicio'))
                ->with('error', 'Ese ejemplar ya no está disponible.');
        }

        // Verificar que el usuario sea un estudiante válido
        $estudiante = $db->table('usuarios')
            ->where('id_usuario', $id_usuario)
            ->where('id_rol', self::ID_ROL_ESTUDIANTE)
            ->get()->getRowArray();

        if (!$estudiante) {
            return redirect()->to(base_url('profesor/inicio'))
                ->with('error', 'El estudiante seleccionado no es válido.');
        }

        // Ambas escrituras en una transacción
        $db->transStart();
        $db->table('prestamos')->insert([
            'id_usuario'     => $id_usuario,
            'id_ejemplar'    => $id_ejemplar,
            'fecha_prestamo' => date('Y-m-d'),
        ]);
        $db->table('ejemplares_fisicos')
            ->where('id_ejemplar', $id_ejemplar)
            ->update(['disponibilidad' => 0]);
        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->to(base_url('profesor/inicio'))
                ->with('error', 'No se pudo registrar el préstamo.');
        }

        return redirect()->to(base_url('profesor/inicio'))
            ->with('mensaje', 'El libro ha sido asignado al estudiante con éxito.');
    }

    public function devolverLibro()
    {
        if (!$this->esProfesor()) {
            return redirect()->to(base_url('/'));
        }

        $id_prestamo = $this->request->getPost('id_prestamo');

        if (!$id_prestamo) {
            return redirect()->to(base_url('profesor/inicio'))
                ->with('error', 'Debe seleccionar un préstamo válido.');
        }

        $db = \Config\Database::connect();

        // Solo préstamos que aún no hayan sido devueltos
        $prestamo = $db->table('prestamos')
            ->where('id_prestamo', $id_prestamo)
            ->where('fecha_devolucion IS NULL')
            ->get()->getRowArray();

        if (!$prestamo) {
            return redirect()->to(base_url('profesor/inicio'))
                ->with('error', 'El préstamo no existe o ya fue devuelto.');
        }

        $db->transStart();
        $db->table('prestamos')
            ->where('id_prestamo', $id_prestamo)
            ->update(['fecha_devolucion' => date('Y-m-d')]);
        $db->table('ejemplares_fisicos')
            ->where('id_ejemplar', $prestamo['id_ejemplar'])
            ->update(['disponibilidad' => 1]);
        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->to(base_url('profesor/inicio'))
                ->with('error', 'Ocurrió un error al procesar la devolución.');
        }

        return redirect()->to(base_url('profesor/inicio'))
            ->with('mensaje', 'Devolución registrada correctamente.');
    }
}