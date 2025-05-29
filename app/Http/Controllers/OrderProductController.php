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
            'fieldsCanFilter' => [
                ['key' => 'orderProductId', 'field' => $request->orderProductId],
                ['key' => 'orderId', 'field' => $request->orderId],
                ['key' => 'productId', 'field' => $request->productId],
            ],
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));          
        $orders_lastID = \App\Models\Order::orderBy('id', 'desc')->first()?->id;
        $products_lastID = \App\Models\Product::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('OrderProduct/Form', [
         'dataControl' => [
                ['key' => 'order_id', 'field' => '', 'type' => 'number', 'posibilities' => $orders_lastID],
                ['key' => 'product_id', 'field' => '', 'type' => 'number', 'posibilities' => $products_lastID],
                ['key' => 'quantity', 'field' => '', 'type' => 'number', 'posibilities' => ''],
                ['key' => 'note', 'field' => '', 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $validation = OrderProduct::where('order_id', $request->order_id)->where('product_id', $request->product_id);
        if ($validation->exists()) {
            return redirect()->back()
                ->withErrors(['order_product' => 'Ya existe una relación con este Order ID y Product ID.'])
                ->withInput();
        }

        $orderProduct = new OrderProduct();
        $orderProduct->order_id = $request->order_id;
        $orderProduct->product_id = $request->product_id;
        $orderProduct->quantity = $request->quantity;
        $orderProduct->note = $request->note;
        $orderProduct->save();

        return redirect()->route('order-products.index');
    }

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));          
        $orderProduct = OrderProduct::findOrFail($id);
        $orders_lastID = \App\Models\Order::orderBy('id', 'desc')->first()?->id;
        $products_lastID = \App\Models\Product::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('OrderProduct/Form', [
            'orderProduct' => $orderProduct,
            'dataControl' => [
                ['key' => 'order_id', 'field' => $orderProduct->order_id, 'type' => 'number', 'posibilities' => $orders_lastID],
                ['key' => 'product_id', 'field' => $orderProduct->product_id, 'type' => 'number', 'posibilities' => $products_lastID],
                ['key' => 'quantity', 'field' => $orderProduct->quantity, 'type' => 'number', 'posibilities' => ''],
                ['key' => 'note', 'field' => $orderProduct->note, 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
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

        $validation = OrderProduct::where('order_id', $request->order_id)->where('product_id', $request->product_id);
        if ($validation->exists() && $validation->id != $id) {
            return redirect()->back()
                ->withErrors(['order_product' => 'Ya existe una relación con este Order ID y Product ID.'])
                ->withInput();
        }

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
