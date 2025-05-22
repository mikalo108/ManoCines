<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Display a listing of products
    public function index()
    {
        $products = Product::paginate(self::PAGINATE_SIZE);
        return view('product.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        return view('product.form');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $request->image;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->save();

        return redirect()->route('product.index');
    }

    // Display the specified product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }

    // Show the form for editing the specified product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.form', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = $request->image;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->save();

        return redirect()->route('product.index');
    }

    // Remove the specified product from storage
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index');
    }
}
