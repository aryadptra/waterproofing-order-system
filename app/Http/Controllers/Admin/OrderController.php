<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::all();

        return view('admin.order.index', [
            'orders' => $order
        ]);
    }

    public function create()
    {
        $service = Service::all();

        return view('admin.order.create', [
            'services' => $service
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'service_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'area' => 'required',
            'schedule' => 'required',
        ]);
    }

    public function edit($id)
    {
        $order = Order::find($id);

        return view('admin.order.edit', [
            'order' => $order
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.order.index')->with('success', 'Order ' . $order->id . ' berhasil diupdate');
    }


    public function show($id)
    {
        $order = Order::find($id);

        return view('admin.order.show', [
            'order' => $order
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        $order->delete();

        return redirect()->route('admin.order.index')->with('success', 'Order ' . $order->id . ' berhasil dihapus');
    }

    public function getService($id)
    {
        $service = Service::find($id);

        return response()->json($service);
    }
}
