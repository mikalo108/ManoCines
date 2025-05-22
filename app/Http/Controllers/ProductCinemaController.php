<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCinema;

class ProductCinemaController extends Controller
{
    protected $paginateSize = 10;

    public function index()
    {
        $productCinemas = ProductCinema::paginate($this->paginateSize);
        return view('productcinema.index', compact('productCinemas'));
    }

    public function create()
    {
        return view('productcinema.form');
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

        return redirect()->route('productcinema.index');
    }

    public function show($id)
    {
        $productCinema = ProductCinema::findOrFail($id);
        return view('productcinema.show', compact('productCinema'));
    }

    public function edit($id)
    {
        $productCinema = ProductCinema::findOrFail($id);
        return view('productcinema.form', compact('productCinema'));
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

        return redirect()->route('productcinema.index');
    }

    public function destroy($id)
    {
        $productCinema = ProductCinema::findOrFail($id);
        $productCinema->delete();

        return redirect()->route('productcinema.index');
    }
}
