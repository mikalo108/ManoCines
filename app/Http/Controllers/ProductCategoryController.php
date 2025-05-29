<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class ProductCategoryController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = ProductCategory::query();

        if ($request->filled('categoryId')) {
            $query->where('id', $request->categoryId);
        }

        if ($request->filled('categoryName')) {
            $query->where('name', 'like', '%' . $request->categoryName . '%');
        }

        $productCategories = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('ProductCategory/Index', [
            'productCategories' => $productCategories,
            'langTable' => fn () => Lang::get('tableProductCategories'),
            'fieldsCanFilter' => [
                ['key' => 'categoryId', 'field' => $request->categoryId],
                ['key' => 'categoryName', 'field' => $request->categoryName],
            ],
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));          

        return Inertia::render('ProductCategory/Form', [
         'dataControl' => [
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new ProductCategory();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('product-categories.index');
    }

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));          
        $category = ProductCategory::findOrFail($id);

        return Inertia::render('ProductCategory/Form', [
         'productCategory' => $category,
         'dataControl' => [
                ['key' => 'name', 'field' => $category->name, 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('product-categories.index');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('product-categories.index');
    }
}
