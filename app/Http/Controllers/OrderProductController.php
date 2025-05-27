<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProduct;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class OrderProductController extends Controller
{
    private const PAGINATE_SIZE = 10;

    // Función para devolver a la página principal del elemento
    public function index()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $orderProducts = OrderProduct::paginate(self::PAGINATE_SIZE);
        return Inertia::render('OrderProduct/Index', ['orderProducts' => $orderProducts, 'langTable' => fn () => Lang::get('tableOrderProducts'),]);
    }

    // Show the form for creating a new order product
    public function create()
    {
        return Inertia::render('OrderProduct/Form');
    }

    // Store a newly created order product in storage
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $orderProduct = new OrderProduct();
        $orderProduct->order_id = $request->order_id;
        $orderProduct->product_id = $request->product_id;
        $orderProduct->quantity = $request->quantity;
        $orderProduct->note = $request->note;
        $orderProduct->save();

        return redirect()->route('order-products.index');
    }

    // Display the specified order product
    public function show($id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        return Inertia::render('OrderProduct/Show', ['orderProduct' => $orderProduct]);
    }

    // Show the form for editing the specified order product
    public function edit($id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        return Inertia::render('OrderProduct/Form', ['orderProduct' => $orderProduct]);
    }

    // Update the specified order product in storage
    public function update(Request $request, $id)
    {
        $orderProduct = OrderProduct::findOrFail($id);

        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $orderProduct->order_id = $request->order_id;
        $orderProduct->product_id = $request->product_id;
        $orderProduct->quantity = $request->quantity;
        $orderProduct->note = $request->note;
        $orderProduct->save();

        return redirect()->route('order-products.index');
    }

    // Remove the specified order product from storage
    public function destroy($id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        $orderProduct->delete();

        return redirect()->route('order-products.index');
    }
}
