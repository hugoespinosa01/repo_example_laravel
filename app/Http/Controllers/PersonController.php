<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $persons = Person::all();

        if ($persons -> isEmpty()) {
            return response() -> json([
                'message' => 'No hay personas'
            ], 404);
        }

        return response() -> json($persons, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'fecha_nacimiento' => 'required|string',
            'estatura' => 'required|integer',
        ]);

        if ($validator -> fails()){
             $data = [
                'message' => 'Error de validación',
                'errors' => $validator -> errors(),
                'status' => 400
             ];
             return response() -> json($data, 400);
        }

        $person = Person::create([
            'nombre' => $request -> nombre,
            'apellido' => $request -> apellido,
            'fecha_nacimiento' => $request -> fecha_nacimiento,
            'estatura' => $request -> estatura,
        ]);

        if (!$person) {
            return response() -> json([
                'message' => 'Error al crear la persona'
            ], 500);
        }

        return response() -> json([
            'message' => 'Persona creada correctamente',
            'staus' => 201,
            'person' => $person
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $person = Person::find($id);

        if (!$person) {
            return response() -> json([
                'message' => 'Persona no encontrada'
            ], 404);
        }

        return response() -> json($person, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $person = Person::find($id);

        if (!$person) {
            return response() -> json([
                'message' => 'Persona no encontrada'
            ], 404);
        }

        $validator = Validator::make($request -> all(), [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'fecha_nacimiento' => 'required|string',
            'estatura' => 'required|integer',
        ]);

        if ($validator -> fails()){
             $data = [
                'message' => 'Error de validación',
                'errors' => $validator -> errors(),
                'status' => 400
             ];
             return response() -> json($data, 400);
        }

        $person -> nombre = $request -> nombre;
        $person -> apellido = $request -> apellido;
        $person -> fecha_nacimiento = $request -> fecha_nacimiento;
        $person -> estatura = $request -> estatura;

        $person -> save();

        return response() -> json([
            'message' => 'Persona actualizada correctamente',
            'status' => 200,
            'person' => $person
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::find($id);

        if (!$person) {
            return response() -> json([
                'message' => 'Persona no encontrada'
            ], 404);
        }

        $person -> delete();

        return response() -> json([
            'message' => 'Persona eliminada correctamente',
            'status' => 200
        ], 200);
    }
}
