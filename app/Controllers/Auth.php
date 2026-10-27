<?php namespace App\Controllers;

use App\Models\UsuariosModel;

class Auth extends BaseController
{
    public function login()
    {
        // 1. Obtener datos del formulario
        $usuarioInput    = $this->request->getPost('usuario');
        $contrasenaInput = $this->request->getPost('contrasena');
        $rolIngreso      = $this->request->getPost('rol_ingreso'); // 'estudiante' o 'personal'

        // 2. Consultar modelo de usuarios
        $usuariosModel = new UsuariosModel();
        
        $usuario = $usuariosModel->select('usuarios.*, roles.nombre_rol')
                                 ->join('roles', 'roles.id_rol = usuarios.id_rol')
                                 ->where('nombre_usuario', $usuarioInput)
                                 ->first();

        // 3. Validar existencia de usuario
        if (!$usuario) {
            return redirect()->to(base_url('login'))->with('error', 'El nombre de usuario no existe.');
        }

        // 4. Validar que la cuenta coincida con el botón seleccionado en el Login
        $nombreRolLower = strtolower($usuario['nombre_rol']);

        if ($rolIngreso === 'estudiante' && $nombreRolLower !== 'estudiante') {
            return redirect()->to(base_url('login'))->with('error', 'Esta cuenta no es de estudiante. Selecciona Personal.');
        }

        if ($rolIngreso === 'personal' && $nombreRolLower === 'estudiante') {
            return redirect()->to(base_url('login'))->with('error', 'Esta cuenta es de estudiante. Selecciona Estudiante.');
        }

        // 5. Validar contraseña (acepta texto plano o hash seguro)
        $passwordCorrecta = password_verify($contrasenaInput, $usuario['contrasena']) || ($contrasenaInput === $usuario['contrasena']);

        if (!$passwordCorrecta) {
            return redirect()->to(base_url('login'))->with('error', 'Contraseña incorrecta.');
        }

        // 6. Iniciar sesión en CodeIgniter
        $sessionData = [
            'id_usuario'     => $usuario['id_usuario'],
            'nombres'        => $usuario['nombres'],
            'apellidos'      => $usuario['apellidos'],
            'nombre_usuario' => $usuario['nombre_usuario'],
            'rol'            => $usuario['nombre_rol'],
            'id_grado'       => $usuario['id_grado'],
            'isLoggedIn'     => true
        ];

        session()->set($sessionData);

        // 7. Redireccionar según el rol
        if ($nombreRolLower === 'estudiante') {
            return redirect()->to(base_url('estudiante/dashboard'));
        } else {
            return redirect()->to(base_url('admin/dashboard'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}