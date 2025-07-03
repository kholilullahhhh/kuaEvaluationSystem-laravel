<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Tema;


class ModulController extends Controller
{

    private $menu = 'modul';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Modul::with(['tema'])->get();
        $menu = $this->menu;
        return view('pages.admin.modul.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        $tema = Tema::all();
        return view('pages.admin.modul.create', compact('menu', 'tema'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $r = $request->all();

        $file = $request->file('sampul');

        // dd($file->getSize() / 1024);
        // if ($file->getSize() / 1024 >= 512) {
        //     return redirect()->route('modul.create')->with('message', 'size gambar');
        // }

        $foto = $request->file('sampul');
        $ext = $foto->getClientOriginalExtension();
        // $r['pas_foto'] = $request->file('pas_foto');

        $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
        $destinationPath = public_path('upload/modul');

        $foto->move($destinationPath, $nameFoto);

        $fileUrl = asset('upload/modul/' . $nameFoto);
        // dd($destinationPath);
        $r['sampul'] = $nameFoto;
        // dd($r);
        Modul::create($r);


        return redirect()->route('modul.index')->with('message', 'store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modul $modul)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Modul::find($id);
        $tema = Tema::all();
        $menu = $this->menu;

        return view('pages.admin.modul.edit', compact('data', 'menu', 'tema'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = Modul::find($r['id']);

        $foto = $request->file('sampul');



        if ($request->hasFile('sampul')) {
            if ($foto->getSize() / 1024 >= 512) {
                return redirect()->route('modul.edit', $r['id'])->with('message', 'size gambar');
            }
            $ext = $foto->getClientOriginalExtension();
            $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
            $destinationPath = public_path('upload/modul');

            $foto->move($destinationPath, $nameFoto);

            $fileUrl = asset('upload/modul/' . $nameFoto);
            $r['sampul'] = $nameFoto;
        } else {
            $r['sampul'] = $request->sampul_old;
        }

        $r['nama_kegiatan'] = $r['judul'];

        // dd($r);
        $data->update($r);

        return redirect()->route('modul.index')->with('message', 'update');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Modul::find($id);
        $data->delete();
        return response()->json($data);
    }
}


