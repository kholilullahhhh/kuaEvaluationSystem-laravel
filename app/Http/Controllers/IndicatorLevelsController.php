<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicator_levels;

class IndicatorLevelsController extends Controller
{
    private $menu = 'indikator_level';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Indicator_levels::get();
        $menu = $this->menu;
        return view('pages.admin.indikator_level.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        return view('pages.admin.indikator_level.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $r = $request->all();
        // dd($r);

        // Menyimpan data guru
        Indicator_levels::create($r);

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Indicator_levels::findOrFail($id);
        $menu = $this->menu;

        return view('pages.admin.indikator_level.edit', compact('data', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = Indicator_levels::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Indicator_levels::find($id);
        $data->delete();

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil dihapus.');
    }

}
