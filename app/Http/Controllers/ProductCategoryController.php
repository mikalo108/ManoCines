<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Display a listing of product categories
    public function index()
    {
        $categories = ProductCategory::paginate(self::PAGINATE_SIZE);
        return view('productcategory.index', compact('categories'));
    }

    // Show the form for creating a new product category
    public function create()
    {
        return view('productcategory.form');
    }

    // Store a newly created product category in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new ProductCategory();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('productcategory.index');
    }

    // Display the specified product category
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('productcategory.show', compact('category'));
    }

    // Show the form for editing the specified product category
    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('productcategory.form', compact('category'));
    }

    // Update the specified product category in storage
    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('productcategory.index');
    }

    // Remove the specified product category from storage
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('productcategory.index');
    }
}
