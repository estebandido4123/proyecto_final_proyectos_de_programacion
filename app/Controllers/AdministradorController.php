<?php namespace App\Controllers;

use App\Models\UsuariosModel; 

class AdministradorController extends BaseController
{
    public function index()
    {
        $session = session();
        
        if (!$session->get('logged_in') || $session->get('id_rol') != 1) {
            return redirect()->to(base_url('/'))->with('error', 'Acceso denegado');
        }

        $usuariosModel = new UsuariosModel();
        
        $data = [
            'profesores'  => $usuariosModel->where('id_rol', 3)->findAll(),
            'estudiantes' => $usuariosModel->where('id_rol', 2)->findAll()
        ];
        
        return view('vista_administrador', $data);
    }

public function agregarUsuario()
    {
        $usuariosModel = new UsuariosModel();
        $nombre_usuario = $this->request->getPost('nombre_usuario');

        // 1. Verificar si el nombre de usuario ya existe en la base de datos
        $existe = $usuariosModel->where('nombre_usuario', $nombre_usuario)->first();
        
        if ($existe) {
            // Si ya existe, lo regresamos a la vista con un mensaje de error
            return redirect()->to(base_url('admin/inicio'))->with('error', 'El nombre de usuario "'.$nombre_usuario.'" ya está en uso. Elige otro.');
        }
        
        // 2. Si no existe, procedemos a guardarlo normalmente
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
}