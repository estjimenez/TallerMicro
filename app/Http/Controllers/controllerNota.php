<?php
namespace App\Http\Controllers;

use App\Models\nota;
use Illuminate\Http\Request;

class controllerNota extends Controller
{
    public function getNotasByEstudiante($codEstudiante)
    {
        $notas = nota::where('codEstudiante', $codEstudiante)->get();
        return response()->json($notas);
    }

    public function store(Request $request, $codEstudiante)
    {
        $validated = $request->validate([
            'actividad' => 'required|string|max:100',
            'nota' => 'required|numeric|between:0,5',
        ]);

        nota::create(array_merge($validated, ['codEstudiante' => $codEstudiante]));
        return response()->json(['message' => 'Nota agregada con éxito'], 201);
    }

    public function update(Request $request, $id)
    {
        $nota = nota::find($id);

        if (!$nota) {
            return response()->json(['message' => 'Nota no encontrada'], 404);
        }

        $validated = $request->validate([
            'actividad' => 'required|string|max:100',
            'nota' => 'required|numeric|between:0,5',
        ]);

        $nota->update($validated);
        return response()->json(['message' => 'Nota actualizada con éxito']);
    }

    public function destroy($id)
    {
        $nota = nota::find($id);

        if (!$nota) {
            return response()->json(['message' => 'Nota no encontrada'], 404);
        }

        $nota->delete();
        return response()->json(['message' => 'Nota eliminada con éxito']);
    }
}
