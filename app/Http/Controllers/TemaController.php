<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\Modul;


class TemaController extends Controller
{
    private $menu = 'tema';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Tema::with(['modul'])->get();

        $menu = $this->menu;
        return view('pages.admin.tema.index', compact('menu', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = $this->menu;
        $modul = Modul::all();
        return view('pages.admin.tema.create', compact('menu', 'modul'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $r = $request->all();

        $file = $request->file('gambar');

        // dd($file->getSize() / 1024);
        // if ($file->getSize() / 1024 >= 512) {
        //     return redirect()->route('agenda.create')->with('message', 'size gambar');
        // }

        $foto = $request->file('gambar');
        $ext = $foto->getClientOriginalExtension();
        // $r['pas_foto'] = $request->file('pas_foto');

        $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
        $destinationPath = public_path('upload/tema');

        $foto->move($destinationPath, $nameFoto);

        $fileUrl = asset('upload/tema/' . $nameFoto);
        // dd($destinationPath);
        $r['gambar'] = $nameFoto;
        // dd($r);
        Tema::create($r);


        return redirect()->route('tema.index')->with('message', 'store');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tema $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Tema::find($id);
        $modul = Modul::all();
        $menu = $this->menu;

        return view('pages.admin.tema.edit', compact('data', 'menu', 'modul'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $r = $request->all();
        $data = Tema::find($r['id']);

        $foto = $request->file('gambar');



        if ($request->hasFile('gambar')) {
            if ($foto->getSize() / 1024 >= 512) {
                return redirect()->route('tema.edit', $r['id'])->with('message', 'size gambar');
            }
            $ext = $foto->getClientOriginalExtension();
            $nameFoto = date('Y-m-d_H-i-s_') . "." . $ext;
            $destinationPath = public_path('upload/tema');

            $foto->move($destinationPath, $nameFoto);

            $fileUrl = asset('upload/tema/' . $nameFoto);
            $r['gambar'] = $nameFoto;
        } else {
            $r['gambar'] = $request->thumbnail_old;
        }

        $r['nama_tema'] = $r['nama'];

        // dd($r);
        $data->update($r);

        return redirect()->route('tema.index')->with('message', 'update');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Tema::find($id);
        $data->delete();
        return response()->json($data);
    }
}
