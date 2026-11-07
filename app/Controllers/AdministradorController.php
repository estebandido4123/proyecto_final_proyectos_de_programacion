<?php namespace App\Controllers;

use App\Models\UsuariosModel; 
use App\Models\CatalogoLibrosModel;
use App\Models\GradosModel;

class AdministradorController extends BaseController
{
    public function index()
    {
        $session = session();
        
        if (!$session->get('logged_in') || $session->get('id_rol') != 1) {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado');
        }

        $usuariosModel = new UsuariosModel();
        $gradosModel = new GradosModel();
        $db = \Config\Database::connect();
        
        // Consultar libros
        $builder = $db->table('catalogo_libros');
        $builder->select('catalogo_libros.*, grados.nombre_grado');
        $builder->join('grados', 'grados.id_grado = catalogo_libros.id_grado', 'left');
        $libros = $builder->get()->getResultArray();

        // Consultar ejemplares físicos para el modal de préstamos
        $builderE = $db->table('ejemplares_fisicos');
        $builderE->select('ejemplares_fisicos.id_ejemplar, catalogo_libros.titulo');
        $builderE->join('catalogo_libros', 'catalogo_libros.id_libro = ejemplares_fisicos.id_libro', 'left');
        $ejemplares = $builderE->get()->getResultArray();

        // Consultar préstamos con JOIN a usuarios y ejemplares/libros
        $prestamos = [];
        if ($db->tableExists('prestamos')) {
            $builderP = $db->table('prestamos');
            $builderP->select('prestamos.*, usuarios.nombres, usuarios.apellidos, catalogo_libros.titulo');
            $builderP->join('usuarios', 'usuarios.id_usuario = prestamos.id_usuario', 'left');
            $builderP->join('ejemplares_fisicos', 'ejemplares_fisicos.id_ejemplar = prestamos.id_ejemplar', 'left');
            $builderP->join('catalogo_libros', 'catalogo_libros.id_libro = ejemplares_fisicos.id_libro', 'left');
            $prestamos = $builderP->get()->getResultArray();
        }

        $data = [
            'profesores'  => $usuariosModel->where('id_rol', 3)->findAll(),
            'estudiantes' => $usuariosModel->where('id_rol', 2)->findAll(),
            'usuarios'    => $usuariosModel->whereIn('id_rol', [2, 3])->findAll(), // Para elegir a quién prestar
            'libros'      => $libros,
            'grados'      => $gradosModel->findAll(),
            'ejemplares'  => $ejemplares,
            'prestamos'   => $prestamos
        ];
        
        return view('vista_administrador', $data);
    }

    // =====================================
    // CRUD USUARIOS
    // =====================================
    public function agregarUsuario()
    {
        $usuariosModel = new UsuariosModel();
        $nombre_usuario = $this->request->getPost('nombre_usuario');

        if ($usuariosModel->where('nombre_usuario', $nombre_usuario)->first()) {
            return redirect()->to(base_url('admin/inicio'))->with('error', 'El usuario "'.$nombre_usuario.'" ya existe.');
        }
        
        $data = [
            'nombres'        => $this->request->getPost('nombres'),
            'apellidos'      => $this->request->getPost('apellidos'),
            'id_rol'         => $this->request->getPost('id_rol'),
            'id_grado'       => $this->request->getPost('id_grado') ?: null,
            'nombre_usuario' => $nombre_usuario,
            'contrasena'     => password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT)
        ];
        
        $usuariosModel->insert($data);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Usuario registrado con éxito');
    }

    public function editarUsuario()
    {
        $usuariosModel = new UsuariosModel();
        $id_usuario = $this->request->getPost('id_usuario'); 
        
        $data = [
            'nombres'        => $this->request->getPost('nombres'),
            'apellidos'      => $this->request->getPost('apellidos'),
            'nombre_usuario' => $this->request->getPost('nombre_usuario')
        ];

        if($this->request->getPost('id_grado')){
            $data['id_grado'] = $this->request->getPost('id_grado');
        }

        if(!empty($this->request->getPost('contrasena'))){
            $data['contrasena'] = password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT);
        }
        
        $usuariosModel->update($id_usuario, $data);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Usuario actualizado con éxito');
    }

    public function eliminarUsuario($id_usuario)
    {
        $usuariosModel = new UsuariosModel();
        $usuariosModel->delete($id_usuario);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Usuario eliminado');
    }

    // =====================================
    // CRUD LIBROS
    // =====================================
    public function agregarLibro()
    {
        $librosModel = new CatalogoLibrosModel();
        $data = [
            'titulo'   => $this->request->getPost('titulo'),
            'id_grado' => $this->request->getPost('id_grado') ?: null
        ];
        
        $librosModel->insert($data);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Libro añadido al catálogo');
    }

    public function editarLibro()
    {
        $librosModel = new CatalogoLibrosModel();
        $id_libro = $this->request->getPost('id_libro');
        
        $data = [
            'titulo'   => $this->request->getPost('titulo'),
            'id_grado' => $this->request->getPost('id_grado') ?: null
        ];
        
        $librosModel->update($id_libro, $data);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Libro actualizado con éxito');
    }

    public function eliminarLibro($id_libro)
    {
        $librosModel = new CatalogoLibrosModel();
        $librosModel->delete($id_libro);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Libro eliminado del catálogo');
    }

    // =====================================
    // CRUD PRÉSTAMOS
    // =====================================
    public function agregarPrestamo()
    {
        $db = \Config\Database::connect();
        $data = [
            'id_ejemplar'    => $this->request->getPost('id_ejemplar'),
            'id_usuario'     => $this->request->getPost('id_usuario'),
            'fecha_prestamo' => date('Y-m-d'),
            'fecha_devolucion' => null
        ];
        
        $db->table('prestamos')->insert($data);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Préstamo registrado exitosamente');
    }

    public function devolverPrestamo($id_prestamo)
    {
        $db = \Config\Database::connect();
        $db->table('prestamos')->where('id_prestamo', $id_prestamo)->update([
            'fecha_devolucion' => date('Y-m-d')
        ]);
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Libro marcado como devuelto');
    }

    public function eliminarPrestamo($id_prestamo)
    {
        $db = \Config\Database::connect();
        $db->table('prestamos')->where('id_prestamo', $id_prestamo)->delete();
        return redirect()->to(base_url('admin/inicio'))->with('mensaje', 'Registro de préstamo eliminado');
    }
}