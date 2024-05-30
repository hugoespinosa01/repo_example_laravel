<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    public $table  = "person";
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'estatura'
    ];

}
