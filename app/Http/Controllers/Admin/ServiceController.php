<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::all();

        return view('admin.service.index', [
            'services' => $service,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $service = Service::create($validate);

        return redirect()->route('admin.service.index')->with('success', 'Service ' . $service->name . ' berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        if (!$service) {
            return redirect()->route('admin.service.index')->with('error', 'Service tidak ditemukan');
        }

        return view('admin.service.edit', [
            'service' => $service,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $service = Service::findOrFail($id);

        if (!$service) {
            return redirect()->route('admin.service.index')->with('error', 'Service tidak ditemukan');
        }

        $service->update($validate);

        return redirect()->route('admin.service.index')->with('success', 'Service ' . $service->name . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if (!$service) {
            return redirect()->route('admin.service.index')->with('error', 'Service tidak ditemukan');
        }

        $service->delete();

        return redirect()->route('admin.service.index')->with('success', 'Service ' . $service->name . ' berhasil dihapus');
    }
}
