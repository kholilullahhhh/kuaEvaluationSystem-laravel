<?php

namespace App\Http\Controllers;

use App\Models\Indicators;
use Illuminate\Http\Request;
use App\Models\performance_scores;
use App\Models\user;

class PerformanceScoreController extends Controller
{
    private $menu = 'indikator_level';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = performance_scores::get();
        $menu = $this->menu;
        return view('pages.admin.indikator_level.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $indicators = Indicators::get();
        $users = User::get();
        $menu = $this->menu;
        return view('pages.admin.indikator_level.create', compact('menu', 'indicators', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $r = $request->all();
        // dd($r);

        // Menyimpan data guru
        performance_scores::create($r);

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = performance_scores::findOrFail($id);
        $indicators = Indicators::get();
        $menu = $this->menu;

        return view('pages.admin.indikator_level.edit', compact('data', 'indicators', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = performance_scores::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = performance_scores::find($id);
        $data->delete();

        return redirect()->route('indikator_level.index')->with('message', 'Data guru berhasil dihapus.');
    }

}
