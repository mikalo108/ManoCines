<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $film = Film::findOrFail($id);
        return view('film.show', compact('film'));
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return view('film.form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'title' => 'required|string|max:255',  
            'director' => 'nullable|string|max:255',  
            'release_year' => 'nullable|integer|min:1800|max:' . date('Y'),  
            'description' => 'nullable|string|max:1000',  
        ]);

        $f = new Film();
        $f->title = $r->title;
        $f->director = $r->director;
        $f->release_year = $r->release_year;
        $f->description = $r->description;
        $f->save();
        return redirect()->route('film.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $f = Film::find($id);
        return view('film.form', ['film' => $f]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'title' => 'required|string|max:255',  
            'director' => 'nullable|string|max:255',  
            'release_year' => 'nullable|integer|min:1800|max:' . date('Y'),  
            'description' => 'nullable|string|max:1000',  
        ]);
        
        $f = Film::find($id);
        $f->title = $r->title;
        $f->director = $r->director;
        $f->release_year = $r->release_year;
        $f->description = $r->description;
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
