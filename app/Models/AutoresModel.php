<?php namespace App\Models;

use CodeIgniter\Model;

class AutoresModel extends Model
{
    protected $table      = 'autores';
    protected $primaryKey = 'id_autor';
    protected $allowedFields = [
        'nombre_completo'
    ];
}