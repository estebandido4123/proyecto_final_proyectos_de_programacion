<?php namespace App\Controllers;

use CodeIgniter\Controller;

class EstudianteController extends BaseController
{
    public function index()
    {
        $session = session();
        
        // Verificar que sea estudiante (rol 2)
        if (!$session->get('logged_in') || $session->get('id_rol') != 2) {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado');
        }

        $id_usuario = $session->get('id_usuario');
        $db = \Config\Database::connect();
        
        // Consultar los préstamos específicos de este estudiante uniéndolos con libros y grados
        $builder = $db->table('prestamos');
        $builder->select('prestamos.*, catalogo_libros.titulo, grados.nombre_grado');
        $builder->join('ejemplares_fisicos', 'ejemplares_fisicos.id_ejemplar = prestamos.id_ejemplar', 'left');
        $builder->join('catalogo_libros', 'catalogo_libros.id_libro = ejemplares_fisicos.id_libro', 'left');
        $builder->join('grados', 'grados.id_grado = catalogo_libros.id_grado', 'left');
        $builder->where('prestamos.id_usuario', $id_usuario);
        $builder->orderBy('prestamos.fecha_prestamo', 'DESC');
        $todos_los_prestamos = $builder->get()->getResultArray();

        // Clasificar en activos (sin fecha de devolución) e historial (con fecha)
        $activos = [];
        $historial = [];
        
        foreach ($todos_los_prestamos as $prestamo) {
            if (empty($prestamo['fecha_devolucion'])) {
                $activos[] = $prestamo;
            } else {
                $historial[] = $prestamo;
            }
        }

        $data = [
            'nombre_estudiante' => $session->get('nombres') . ' ' . $session->get('apellidos'),
            'activos'           => $activos,
            'historial'         => $historial
        ];
        
        return view('vista_estudiante', $data);
    }
}