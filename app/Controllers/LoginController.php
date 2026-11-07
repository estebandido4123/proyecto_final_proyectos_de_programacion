<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuariosModel; 

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function autenticar()
    {
        $usuario = $this->request->getPost('nombre_usuario');
        $contrasena = $this->request->getPost('contrasena');

        $usuariosModel = new UsuariosModel();
        $datosUsuario = $usuariosModel->where('nombre_usuario', $usuario)->first();

        if ($datosUsuario && password_verify($contrasena, $datosUsuario['contrasena'])) {
            
            $session = session();
            $session->set([
                'id_usuario'     => $datosUsuario['id_usuario'],
                'nombre_usuario' => $datosUsuario['nombre_usuario'],
                'nombres'        => $datosUsuario['nombres'],
                'apellidos'      => $datosUsuario['apellidos'],
                'id_rol'         => $datosUsuario['id_rol'],
                'logged_in'      => true
            ]);

            if ($datosUsuario['id_rol'] == 1) { 
                return redirect()->to(base_url('admin/inicio'));
            } else if ($datosUsuario['id_rol'] == 2) { 
                // CORRECCIÓN: Redirige al controlador en lugar de cargar la vista vacía
                return redirect()->to(base_url('estudiante/inicio')); 
            } else if ($datosUsuario['id_rol'] == 3) { 
                return redirect()->to(base_url('profesor/inicio')); 
            }

        } else {
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
        }
    }
    
    public function salir()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }
}