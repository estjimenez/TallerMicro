<?php
namespace App\Http\Controllers;

use App\Models\modelEstudiante;
use App\Models\nota;
use Illuminate\Http\Request;

class controllerEstudiante extends Controller
{
    public function index()
    {
        $estudiantes = modelEstudiante::all()->map(function ($estudiante) {
            $notas = nota::where('codEstudiante', $estudiante->cod)->get();
            $promedio = $notas->avg('nota');

            $estudiante->nota_definitiva = $notas->isEmpty() ? 'No hay nota' : number_format($promedio, 2);
            $estudiante->estado = $notas->isEmpty() ? 'Sin notas' : ($promedio >= 3 ? 'Aprobó' : 'Perdió');

            return $estudiante;
        });

        return response()->json([
            'estudiantes' => $estudiantes,
            'resumen' => [
                'sin_notas' => $estudiantes->where('estado', 'Sin notas')->count(),
                'aprobados' => $estudiantes->where('estado', 'Aprobó')->count(),
                'perdidos' => $estudiantes->where('estado', 'Perdió')->count(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cod' => 'required|unique:estudiantes,cod',
            'nombres' => 'required|string|max:250',
            'email' => 'required|email|unique:estudiantes,email',
        ]);

        modelEstudiante::create($validated);
        return response()->json(['message' => 'Estudiante creado con éxito'], 201);
    }

    public function update(Request $request, $cod)
    {
        $estudiante = modelEstudiante::find($cod);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombres' => 'required|string|max:250',
            'email' => "required|email|unique:estudiantes,email,{$cod},cod",
        ]);

        $estudiante->update($validated);
        return response()->json(['message' => 'Estudiante actualizado con éxito']);
    }

    public function destroy($cod)
    {
        $estudiante = modelEstudiante::find($cod);

        if (!$estudiante) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $notas = nota::where('codEstudiante', $cod)->exists();
        if ($notas) {
            return response()->json(['message' => 'No se puede eliminar el estudiante porque tiene notas registradas'], 400);
        }

        $estudiante->delete();
        return response()->json(['message' => 'Estudiante eliminado con éxito']);
    }
}
