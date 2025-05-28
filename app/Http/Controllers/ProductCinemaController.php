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

        $productCinemas = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('ProductCinema/Index', [
            'productCinemas' => $productCinemas,
            'langTable' => fn () => Lang::get('tableProductCinemas'),
            'fieldsCanFilter' => ['productCinemaId', 'cinemaId', 'productId'],
        ]);
    }

    public function create()
    {
        return Inertia::render('ProductCinema/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $productCinema = new ProductCinema();
        $productCinema->cinema_id = $request->cinema_id;
        $productCinema->product_id = $request->product_id;
        $productCinema->save();

        return redirect()->route('product-cinemas.index');
    }

    public function show($id)
    {
        $productCinema = ProductCinema::findOrFail($id);
        return Inertia::render('ProductCinema/Show', ['productCinema' => $productCinema]);
    }

    public function edit($id)
    {
        $productCinema = ProductCinema::findOrFail($id);
        return Inertia::render('ProductCinema/Form', ['productCinema' => $productCinema]);
    }

    public function update(Request $request, $id)
    {
        $productCinema = ProductCinema::findOrFail($id);

        $request->validate([
            'cinema_id' => 'required|integer|exists:cinemas,id',
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $productCinema->cinema_id = $request->cinema_id;
        $productCinema->product_id = $request->product_id;
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
