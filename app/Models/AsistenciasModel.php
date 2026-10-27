<?php namespace App\Models;

use CodeIgniter\Model;

class AsistenciasModel extends Model
{
    protected $table      = 'asistencias';
    protected $primaryKey = 'id_asistencia';
    protected $allowedFields = [
        'id_usuario',
        'fecha',
        'hora_registro',
        'estado',
        'observaciones'
    ];
}