<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cinema;

class CinemaController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $cinema = Cinema::findOrFail($id);
        return view('cinema.show', compact('cinema'));
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return view('cinema.form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'location' => 'required|string|max:255',  
            'description' => 'nullable|string|max:1000',  
        ]);

        $c = new Cinema();
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->save();
        return redirect()->route('cinema.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $c = Cinema::find($id);
        return view('cinema.form', ['cinema' => $c]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'location' => 'required|string|max:255',  
            'description' => 'nullable|string|max:1000',  
        ]);
        
        $c = Cinema::find($id);
        $c->name = $r->name;
        $c->location = $r->location;
        $c->description = $r->description;
        $c->save();
        return redirect()->route('cinema.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $c = Cinema::find($id);
        $c->delete();
        return redirect()->route('cinema.index');
    }
}
