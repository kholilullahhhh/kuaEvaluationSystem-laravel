<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SppPlan;

class SppController extends Controller
{
    private $menu = 'spp';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = SppPlan::get();
        $menu = $this->menu;
        return view('pages.admin.spp.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        return view('pages.admin.spp.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $r = $request->all();
        // dd($r);

        // Menyimpan data guru
        SppPlan::create($r);

        return redirect()->route('spp.index')->with('message', 'Data guru berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = SppPlan::findOrFail($id);
        $menu = $this->menu;

        return view('pages.admin.spp.edit', compact('data', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = SppPlan::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('spp.index')->with('message', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = SppPlan::find($id);
        $data->delete();

        return redirect()->route('spp.index')->with('message', 'Data guru berhasil dihapus.');
    }

}
