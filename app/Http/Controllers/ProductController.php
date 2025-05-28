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
            'fieldsCanFilter' => [
                ['key' => 'productId', 'field' => $request->productId],
                ['key' => 'productName', 'field' => $request->productName],
                ['key' => 'categoryId', 'field' => $request->categoryId],
            ],
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Product/Form', [
         'dataControl' => [
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'description', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'image', 'field' => '', 'type' => 'image', 'posibilities' => ''],
                ['key' => 'price', 'field' => '', 'type' => 'number', 'posibilities' => ''],
                ['key' => 'cinema_id', 'field' => '', 'type' => 'number', 'posibilities' => $cinemas_lastID],
            ],
        ]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $product = new Product();
        $product->name = $r->name;
        $product->description = $r->description;
        
        // Si hay archivo, guárdalo con un nombre único y extensión original
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('film_', true) . '.' . $extension;
            $file->storeAs('/storage/films', $filename);
            $product->image = $filename;
        }

        $product->price = $r->price;
        $product->category = $r->category;
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
        app()->setLocale(session('locale', app()->getLocale()));  
        $product = Product::findOrFail($id);
        $cinemas_lastID = \App\Models\Cinema::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Product/Form', [
         'product' => $product,
         'dataControl' => [
                ['key' => 'name', 'field' => $product->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'description', 'field' => $product->description, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'image', 'field' => $product->image, 'type' => 'image', 'posibilities' => ''],
                ['key' => 'price', 'field' => $product->price, 'type' => 'number', 'posibilities' => ''],
                ['key' => 'cinema_id', 'field' => $product->cinema_id, 'type' => 'number', 'posibilities' => $cinemas_lastID],
            ],
        ]);
    }

    public function update(Request $r, $id)
    {
        $product = Product::findOrFail($id);

        $r->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $product->name = $r->name;
        $product->description = $r->description;
        
        // Si hay archivo, guárdalo con un nombre único y extensión original
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('film_', true) . '.' . $extension;
            $file->storeAs('/storage/films', $filename);
            $product->image = $filename;
        }

        $product->price = $r->price;
        $product->category = $r->category;
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
