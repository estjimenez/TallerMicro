<?php

namespace App\Models;

use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class modelEstudiante extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'estudiantes';
    protected $primaryKey = 'cod';
    protected $fillable = [
        'cod',
        'nombres',
        'email'
    ];
    public function notas()
    {
        return $this->hasMany(Nota::class, 'codEstudiante');
    }
}
