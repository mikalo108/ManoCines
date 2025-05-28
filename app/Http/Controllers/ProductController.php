<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class ProductController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Product::query();

        if ($request->filled('productId')) {
            $query->where('id', $request->productId);
        }

        if ($request->filled('productName')) {
            $query->where('name', 'like', '%' . $request->productName . '%');
        }

        if ($request->filled('categoryId')) {
            $query->where('category_id', $request->categoryId);
        }

        $products = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('Product/Index', [
            'products' => $products,
            'langTable' => fn () => Lang::get('tableProducts'),
            'fieldsCanFilter' => ['productId', 'productName', 'categoryId'],
        ]);
    }

    public function create()
    {
        return Inertia::render('Product/Form');
    }

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

        return redirect()->route('products.index');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return Inertia::render('Product/Show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return Inertia::render('Product/Form', ['product' => $product]);
    }

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

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index');
    }
}
