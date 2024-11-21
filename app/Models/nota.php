<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota extends Model
{
    use HasFactory;

    protected $table = 'notas';
    protected $fillable = [
        'actividad',
         'nota', 
         'codEstudiante'];

    public function estudiante()
    {
        return $this->belongsTo(modelEstudiante::class, 'codEstudiante');
    }
}
