<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chair;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class ChairController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página principal del elemento
    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Chair::query();
        
        // Filtrar por id de la butaca si se proporciona
        if ($request->filled('chairId')) {
            $query->where('name', 'like', '%' . $request->chairId . '%');
        }

         // Filtrar por nombre de la butaca si se proporciona
        if ($request->filled('chairName')) {
            $query->where('name', 'like', '%' . $request->chairName . '%');
        }

        // Obtener las ciudades paginadas y ordenadas por ID ascendente
         $chairList = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);

        return Inertia::render('Chair/Index', [
            'chairs' => $chairList,
            'filters' => $request->all('search', 'trashed'),
            'langTable' => fn () => Lang::get('tableChairs'),
        ]);
    }

    // Función para devolver a la página de detalles del elemento que se pide
    public function show($id){
        $chair = Chair::findOrFail($id);
        return Inertia::render('Chair/Show', ['chair' => $chair]);
    }

    // Función para devolver a la página de creación del elemento
    public function create() {
        return Inertia::render('Chair/Form');  
    }

    // Función para guardar el elemento en la base de datos
    public function store(Request $r) { 
        $r->validate([
            'room_id' => 'required|integer|exists:rooms,id',  
            'row' => 'required|string|max:10',  
            'column' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $ch = new Chair();
        $ch->room_id = $r->room_id;
        $ch->row = $r->row;
        $ch->column = $r->column;
        $ch->state = $r->state;
        $ch->price = $r->price;
        $ch->save();
        return redirect()->route('chairs.index');
    }

    // Función para devolver a la página de edición del elemento
    public function edit($id) { 
        $ch = Chair::find($id);
        return Inertia::render('Chair/Form', ['chair' => $ch]);
    }

    // Función para actualizar el elemento en la base de datos
    public function update($id, Request $r) { 
        $r->validate([
            'room_id' => 'required|integer|exists:rooms,id',  
            'row' => 'required|string|max:10',  
            'column' => 'required|string|max:10',
            'state' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        
        $ch = Chair::find($id);
        $ch->room_id = $r->room_id;
        $ch->row = $r->row;
        $ch->column = $r->column;
        $ch->state = $r->state;
        $ch->price = $r->price;
        $ch->save();
        return redirect()->route('chairs.index');
    }

    // Funcion para eliminar el elemento de la base de datos
    public function destroy($id) { 
        $ch = Chair::find($id);
        $ch->delete();
        return redirect()->route('chairs.index');
    }
}
