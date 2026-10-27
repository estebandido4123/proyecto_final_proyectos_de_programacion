<?php namespace App\Models;

use CodeIgniter\Model;

class JustificacionesModel extends Model
{
    protected $table      = 'justificaciones';
    protected $primaryKey = 'id_justificacion';
    protected $allowedFields = [
        'id_asistencia',
        'motivo',
        'archivo_adjunto',
        'fecha_emision'
    ];
}