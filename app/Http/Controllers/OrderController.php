<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::where('user_id', Auth::user()->id)->get();

        return view('user.order.index', [
            'orders' => $order,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = Service::all();

        return view('user.order.create', [
            'services' => $service
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->route('user.order.index')->with('success', 'Order ' . $order->id . ' berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        return view('user.order.show', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
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

        return redirect()->route('user.order.show', ['id' => $order->id])->with('success', 'Tawaran pesanan ' . $order->id . ' berhasil diterima. Silahkan lakukan pembayaran dan upload bukti pembayaran pada tombol dibawah ini');
    }

    public function uploadProof(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        $validate = $request->validate([
            'proof_of_transfer' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($order->proof_of_transfer && file_exists(storage_path('app/public/' . $order->proof_of_transfer))) {
            Storage::delete('public/' . $order->proof_of_transfer);
        }

        // Upload gambar baru
        $file = $request->file('proof_of_transfer');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/proof_of_transfer', $filename);

        $order->orderDetail()->update([
            'proof_of_transfer' => 'proof_of_transfer/' . $filename,
        ]);

        $order->update([
            'status' => 'waiting_confirmation',
        ]);

        return redirect()->route('user.order.show', ['id' => $order->id])->with('success', 'Bukti pembayaran berhasil diupload');
    }
}
