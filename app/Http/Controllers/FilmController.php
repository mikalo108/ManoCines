<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class FilmController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request) {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Film::query();

        if ($request->filled('filmId')) {
            $query->where('id', $request->filmId);
        }

        if ($request->filled('filmName')) {
            $query->where('name', 'like', '%' . $request->filmName . '%');
        }

        $films = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('Film/Index', [
            'films' => $films,
            'langTable' => fn () => Lang::get('tableFilms'),
            'fieldsCanFilter' => ['filmId', 'filmName'],
        ]);
    }

    public function show($id){
        $film = Film::findOrFail($id);
        return Inertia::render('Film/Show', ['film' => $film]);
    }

    public function create() {
        return Inertia::render('Film/Form');  
    }

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
        return redirect()->route('films.index');
    }

    public function edit($id) { 
        $f = Film::find($id);
        return Inertia::render('Film/Form', ['film' => $f]);
    }

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
        return redirect()->route('films.index');
    }

    public function destroy($id) { 
        $f = Film::find($id);
        $f->delete();
        return redirect()->route('films.index');
    }
}
