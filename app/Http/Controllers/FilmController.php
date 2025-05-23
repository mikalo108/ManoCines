<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use Inertia\Inertia;

class FilmController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $film = Film::findOrFail($id);
        return Inertia::render('Film/Show', ['film' => $film]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return Inertia::render('Film/Form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'image' => 'nullable|string|max:255',  
            'overview' => 'nullable|string',  
            'trailer' => 'nullable|string|max:255',  
        ]);

        $f = new Film();
        $f->name = $r->name;
        $f->image = $r->image;
        $f->overview = $r->overview;
        $f->trailer = $r->trailer;
        $f->save();
        return redirect()->route('film.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $f = Film::find($id);
        return Inertia::render('Film/Form', ['film' => $f]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'image' => 'nullable|string|max:255',  
            'overview' => 'nullable|string',  
            'trailer' => 'nullable|string|max:255',  
        ]);
        
        $f = Film::find($id);
        $f->name = $r->name;
        $f->image = $r->image;
        $f->overview = $r->overview;
        $f->trailer = $r->trailer;
        $f->save();
        return redirect()->route('film.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $f = Film::find($id);
        $f->delete();
        return redirect()->route('film.index');
    }
}
