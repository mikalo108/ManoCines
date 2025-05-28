<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class CityController extends Controller
{
    private const PAGINATE_SIZE = 5;
    
    // Función para devolver a la página principal del elemento
    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = City::query();
        // Filtrar por nombre de la ciudad si se proporciona
        if ($request->filled('cityName')) {
            $query->where('name', 'like', '%' . $request->cityName . '%');
        }

        // Obtener las ciudades paginadas y ordenadas por ID ascendente
         $cityList = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);

        return Inertia::render('City/Index', [
            'cities' => $cityList,
            'cityName' => $request->cityName ?? '',
            'filters' => $request->all('search', 'trashed'),
            'langTable' => fn () => Lang::get('tableCities'),
        ]);
    }   

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $city = City::findOrFail($id);
        return Inertia::render('City/Show', ['city' => $city]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return Inertia::render('City/Form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255', 
        ]);

        $c = new City();
        $c->name = $r->name;
        $c->cinema_id = $r->cinema_id;
        $c->save();
        return redirect()->route('cities.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $c = City::find($id);
        return Inertia::render('City/Form', ['city' => $c]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'name' => 'required|string|max:255', 
        ]);
        
        $c = City::find($id);
        $c->name = $r->name;
        $c->cinema_id = $r->cinema_id;
        $c->save();
        return redirect()->route('cities.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $c = City::find($id);
        $c->delete();
        return redirect()->route('cities.index');
    }
}
