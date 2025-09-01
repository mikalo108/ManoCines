<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

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

    public function indexBarProducts($cinema_id, $film_id, $room_id, $time_id, Request $r){
        app()->setLocale(session('locale', app()->getLocale()));
        session()->put('cinema_id', $cinema_id);
        session()->put('film_id', $film_id);
        session()->put('room_id', $room_id);
        session()->put('time_id', $time_id);

        // Get chairs selected from session
        $chairsSelected = $r->session()->get('chairsSelected', []);

        // Get products selected from session if any
        $selectedProducts = session()->get('selectedProducts', []);

        // Get all product categories with their products filtered by cinema
        $categories = ProductCategory::with(['products' => function($query) use ($cinema_id) {
            $query->whereHas('cinemas', function($q) use ($cinema_id) {
                $q->where('cinemas.id', $cinema_id);
            });
        }])->get();

        // Transform categories to array with category name as key and products as value
        $result = [];
        foreach ($categories as $category) {
            $result[] = [
                $category->name => $category->products->toArray()
            ];
        }

        return Inertia::render('Product/IndexBarProducts', [
            'categories' => $result,
            'cinema_id' => $cinema_id,
            'film_id' => $film_id,
            'room_id' => $room_id,
            'time_id' => $time_id,
            'chairsSelected' => $chairsSelected,
            'selectedProducts' => $selectedProducts,
            'langTable' => fn () => Lang::get('tableProducts'),
            'langTableChair' => fn () => Lang::get('tableChairs'),
            'lang' => fn () => Lang::get('general'),
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $product_categories_lastID = ProductCategory::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Product/Form', [
         'dataControl' => [
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'description', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'image', 'field' => '', 'type' => 'image', 'posibilities' => ''],
                ['key' => 'price', 'field' => '', 'type' => 'number', 'posibilities' => ''],
                ['key' => 'product_category_id', 'field' => '', 'type' => 'number', 'posibilities' => $product_categories_lastID],
            ],
        ]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'nullable|string|max:255',
            'product_category_id' => 'nullable|string|max:255',
        ]);

        $product = new Product();
        $product->name = $r->name;
        $product->description = $r->description;
        
        // Si hay archivo, guárdalo con un nombre único y extensión original
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('film_', true) . '.' . $extension;
            Storage::disk('public')->putFileAs('products', $file, $filename);
            $product->image = $filename;
        }

        $product->price = $r->price;
        $product->product_category_id = $r->product_category_id;
        $product->save();

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $product = Product::findOrFail($id);
        $product_categories_lastID = ProductCategory::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Product/Form', [
         'product' => $product,
         'dataControl' => [
                ['key' => 'name', 'field' => $product->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'description', 'field' => $product->description, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'image', 'field' => $product->image, 'type' => 'image', 'posibilities' => ''],
                ['key' => 'price', 'field' => $product->price, 'type' => 'number', 'posibilities' => ''],
                ['key' => 'product_category_id', 'field' => $product->product_category_id, 'type' => 'number', 'posibilities' => $product_categories_lastID],
            ],
        ]);
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'nullable|string|max:255',
            'product_category_id' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $r->name;
        $product->description = $r->description;
        
        // Si hay archivo, guárdalo con un nombre único y extensión original
        if ($r->hasFile('image')) {
            $file = $r->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('film_', true) . '.' . $extension;
            Storage::disk('public')->putFileAs('products', $file, $filename);
            $product->image = $filename;
        }

        $product->price = $r->price;
        $product->product_category_id = $r->product_category_id;
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
