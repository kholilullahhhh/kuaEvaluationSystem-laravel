<?php

namespace App\Http\Controllers;

use App\Models\Indicators;
use Illuminate\Http\Request;


class IndicatorsController extends Controller
{
    private $menu = 'indikator';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Indicators::get();
        $menu = $this->menu;
        return view('pages.admin.indikator.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        return view('pages.admin.indikator.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $r = $request->all();
        // dd($r);

        // Menyimpan data Indikator
        Indicators::create($r);

        return redirect()->route('indikator.index')->with('message', 'Data Indikator berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Indicators::findOrFail($id);
        $menu = $this->menu;

        return view('pages.admin.indikator.edit', compact('data', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = Indicators::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('indikator.index')->with('message', 'Data Indikator berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Indicators::find($id);
        $data->delete();

        return redirect()->route('indikator.index')->with('message', 'Data Indikator berhasil dihapus.');
    }

}
