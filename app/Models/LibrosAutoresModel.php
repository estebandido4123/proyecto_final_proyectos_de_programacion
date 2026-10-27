<?php namespace App\Models;

use CodeIgniter\Model;

class LibrosAutoresModel extends Model
{
    protected $table      = 'libros_autores';
    // CodeIgniter 4 maneja llaves primarias compuestas de forma limitada en su Model base.
    // Para esta tabla pivote, se omiten los métodos que requieren $primaryKey o se usa Query Builder.
    protected $allowedFields = [
        'id_libro',
        'id_autor'
    ];
}