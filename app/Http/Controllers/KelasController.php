<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;


class KelasController extends Controller
{
    private $menu = 'kelas';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Classes::get();
        $menu = $this->menu;
        return view('pages.admin.kelas.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        return view('pages.admin.kelas.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $r = $request->all();
        // dd($r);

        // Menyimpan data guru
        Classes::create($r);

        return redirect()->route('kelas.index')->with('message', 'Data guru berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Classes::findOrFail($id);
        $menu = $this->menu;

        return view('pages.admin.kelas.edit', compact('data', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = Classes::find($r['id']);

        // dd($r);
        $data->update($r);

        return redirect()->route('kelas.index')->with('message', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Classes::find($id);
        $data->delete();

        return redirect()->route('kelas.index')->with('message', 'Data guru berhasil dihapus.');
    }

}
