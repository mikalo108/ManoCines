<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCinema;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class ProductCinemaController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = ProductCinema::query();

        if ($request->filled('productCinemaId')) {
            $query->where('id', $request->productCinemaId);
        }

        if ($request->filled('cinemaId')) {
            $query->where('cinema_id', $request->cinemaId);
        }

        if ($request->filled('productId')) {
            $query->where('product_id', $request->productId);
        }

        if ($request->filled('quantity')) {
            $query->where('quantity', $request->quantity);
        }

        $productCinemas = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('ProductCinema/Index', [
            'productCinemas' => $productCinemas,
            'langTable' => fn () => Lang::get('tableProductCinemas'),
            'fieldsCanFilter' => [
                ['key' => 'productCinemaId', 'field' => $request->productCinemaId],
                ['key' => 'cinemaId', 'field' => $request->cinemaId],
                ['key' => 'productId', 'field' => $request->productId],
                ['key' => 'quantity', 'field' => $request->quantity],
            ],
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));        
        $products_lastID = \App\Models\Product::orderBy('id', 'desc')->first()?->id;
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('ProductCinema/Form', [
         'dataControl' => [
                ['key' => 'product_id', 'field' => '', 'type' => 'number', 'posibilities' => $products_lastID],
                ['key' => 'cinema_id', 'field' => '', 'type' => 'number', 'posibilities' => $cinemas_lastID],
                ['key' => 'quantity', 'field' => '', 'type' => 'number', 'posibilities' => ''],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $validation = ProductCinema::where('cinema_id', $request->cinema_id)->where('product_id', $request->product_id);
        if ($validation->exists()) {
            return redirect()->back()
                ->withErrors(['product_cinema' => 'Ya existe una relación con esta Cinema ID y Product ID.'])
                ->withInput();
        }

        $productCinema = new ProductCinema();
        $productCinema->cinema_id = $request->cinema_id;
        $productCinema->product_id = $request->product_id;
        $productCinema->quantity = $request->quantity;
        $productCinema->save();

        return redirect()->route('product-cinemas.index');
    }

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));        
        $productCinema = ProductCinema::findOrFail($id);
        $products_lastID = \App\Models\Product::orderBy('id', 'desc')->first()?->id;
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;
         

        return Inertia::render('ProductCinema/Form', [
            'productCinema' => $productCinema,
            'dataControl' => [
                ['key' => 'product_id', 'field' => $productCinema->product_id, 'type' => 'number', 'posibilities' => $products_lastID],
                ['key' => 'cinema_id', 'field' => $productCinema->cinema_id, 'type' => 'number', 'posibilities' => $cinemas_lastID],
                ['key' => 'quantity', 'field' => $productCinema->quantity, 'type' => 'number', 'posibilities' => ''],
            ],
        ]);
        
    }

    public function update(Request $request, $id)
    {
        $productCinema = ProductCinema::findOrFail($id);

        $request->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $validation = ProductCinema::where('cinema_id', $request->cinema_id)->where('product_id', $request->product_id);
        if ($validation->exists() && $validation->id != $id) {
            return redirect()->back()
                ->withErrors(['product_cinema' => 'Ya existe una relación con esta Cinema ID y Product ID.'])
                ->withInput();
        }

        $productCinema->cinema_id = $request->cinema_id;
        $productCinema->product_id = $request->product_id;
        $productCinema->quantity = $request->quantity;
        $productCinema->save();

        return redirect()->route('product-cinemas.index');
    }

    public function destroy($id)
    {
        $productCinema = ProductCinema::findOrFail($id);
        $productCinema->delete();

        return redirect()->route('product-cinemas.index');
    }
}
