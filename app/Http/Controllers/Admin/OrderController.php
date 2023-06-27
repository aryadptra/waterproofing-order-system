<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $order = Order::create([
            'service_id' => $request->service_id,
            'user_id' => Auth::user()->id,
            'status' => 'pending',
        ]);

        if (!$order) {
            return redirect()->back()->with('error', 'Order gagal ditambahkan');
        }

        $order->orderDetail()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'area' => $request->area,
            'address' => $request->address,
            'schedule' => $request->schedule,
            'message' => $request->message,
            'total' => $request->total,
        ]);

        return redirect()->route('admin.order.index')->with('success', 'Order ' . $order->id . ' berhasil ditambahkan');
    }

    public function edit($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        $service = Service::all();

        return view('admin.order.edit', [
            'order' => $order,
            'services' => $service
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        $validate = $request->validate([
            'service_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'area' => 'required',
            'schedule' => 'required',
            'message' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);

        $order->update([
            'service_id' => $request->service_id,
            'status' => $request->status,
        ]);

        $order->orderDetail()->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'area' => $request->area,
            'address' => $request->address,
            'schedule' => $request->schedule,
            'message' => $request->message,
            'total' => $request->total,
        ]);

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

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        // Get button name
        $button = request()->input('button');

        if ($button == 'wait_payment') {
            $order->status = 'wait_payment';
        } else if ($button == 'canceled') {
            $order->status = 'canceled';
        }

        $order->update([
            'status' => $order->status
        ]);

        return redirect()->route('admin.order.index')->with('success', 'Order ' . $order->id . ' berhasil diupdate');
    }
}