<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

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
            'fieldsCanFilter' => [
                ['key' => 'filmId', 'field' => $request->filmId],
                ['key' => 'filmName', 'field' => $request->filmName],
            ],
        ]);
    }

    public function indexForACinema($cinema_id)
    {
        $cinema = \App\Models\Cinema::findOrFail($cinema_id);
        $films = Film::whereHas('times.room.cinemas', function ($query) use ($cinema_id) {
            $query->where('cinemas.id', $cinema_id);
        })->orderBy('id', 'desc')->get();

        return Inertia::render('Film/IndexForACinema', [
            'films' => $films,
            'cinema' => $cinema,
            'langTable' => fn () => Lang::get('tableFilms'),
        ]);
    }

    public function create() {
        app()->setLocale(session('locale', app()->getLocale()));          

        return Inertia::render('Film/Form', [
         'dataControl' => [
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'image', 'field' => '', 'type' => 'image', 'posibilities' => ''],
                ['key' => 'overview', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'trailer', 'field' => '', 'type' => 'text', 'posibilities' => ''],
            ],
        ]); 
    }

    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',  
            'overview' => 'nullable|string',  
            'trailer' => 'nullable|string|max:255',  
        ]);

        $f = new Film();
        $f->name = $r->name;
        $f->overview = $r->overview;
        $f->trailer = $r->trailer;

        // Si hay archivo, guárdalo con un nombre único y extensión original
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('film_', true) . '.' . $extension;
            Storage::disk('public')->putFileAs('films', $file, $filename);
            $f->image = $filename;
        }

        $f->save();
        return redirect()->route('films.index');
    }

    public function edit($id) { 
        app()->setLocale(session('locale', app()->getLocale()));          
        $f = Film::find($id);

        return Inertia::render('Film/Form', [
         'film' => $f,
         'dataControl' => [
                ['key' => 'name', 'field' => $f->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'image', 'field' => $f->image, 'type' => 'image', 'posibilities' => ''],
                ['key' => 'overview', 'field' => $f->overview, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'trailer', 'field' => $f->trailer, 'type' => 'text', 'posibilities' => ''],
            ],
        ]); 
    }

    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255',  
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',  
            'overview' => 'required|string',
            'trailer' => 'required|string|max:255',  
        ]);

        $f = Film::find($id);
        $f->name = $r->name;
        $f->overview = $r->overview;
        $f->trailer = $r->trailer;

        // Si hay archivo, guárdalo con un nombre único y extensión original
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('film_', true) . '.' . $extension;
            Storage::disk('public')->putFileAs('films', $file, $filename);
            $f->image = $filename;
        }

        $f->save();
        return redirect()->route('films.index');
    }

    public function destroy($id) { 
        $f = Film::find($id);
        $f->delete();
        return redirect()->route('films.index');
    }
}
