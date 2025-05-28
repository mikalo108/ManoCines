<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProduct;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class OrderProductController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = OrderProduct::query();

        if ($request->filled('orderProductId')) {
            $query->where('id', $request->orderProductId);
        }

        if ($request->filled('orderId')) {
            $query->where('order_id', $request->orderId);
        }

        if ($request->filled('productId')) {
            $query->where('product_id', $request->productId);
        }

        $orderProducts = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('OrderProduct/Index', [
            'orderProducts' => $orderProducts,
            'langTable' => fn () => Lang::get('tableOrderProducts'),
            'fieldsCanFilter' => ['orderProductId', 'orderId', 'productId'],
        ]);
    }

    public function create()
    {
        return Inertia::render('OrderProduct/Form');
    }

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

    public function show($id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        return Inertia::render('OrderProduct/Show', ['orderProduct' => $orderProduct]);
    }

    public function edit($id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        return Inertia::render('OrderProduct/Form', ['orderProduct' => $orderProduct]);
    }

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

    public function destroy($id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        $orderProduct->delete();

        return redirect()->route('order-products.index');
    }
}
