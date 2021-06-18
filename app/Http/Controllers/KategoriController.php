<?php

namespace App\Http\Controllers;

use App\Models\Kategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    //method halaman list kategori
    public function index()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Kategori',
            'sidebar' => 'Kategori',
            'user' => $user,
            'kategoris' => Kategorie::get(),
        ];
        return view('admin.kategori', $data);
    }

    //method post buat kategori baru
    public function create(Request $request)
    {
        //check validasi form
        if ($request->validate([
            'kategori' => 'required|unique:kategories,kategori',
        ])) {

            //simpan kategori baru
            $kategori = new Kategorie;
            $kategori->kategori = $request->kategori;
            $kategori->save();

            //kembali dengan notifikasi
            $request->session()->flash('success', ' Kategori ' . $request->kategori . ' berhasil ditambahkan');
            return redirect()->route('kategori');
        }
    }

    //method halaman kategori by id
    public function edit($id)
    {
        $user = Auth::user();
        // SELECT * FROM kategori WHERE id = $id  LIMIT 1;
        $kategori = Kategorie::where(['id' => $id])->first();

        $data = [
            'title' => ' Kategori Edit',
            'sidebar' => 'Kategori',
            'user' => $user,
            'kategori' =>  $kategori,
        ];
        return view('admin.kategori-edit', $data);
    }

    //method post update kategori 
    public function update(Request $request)
    {
        //check validasi form
        if ($request->validate([
            'kategori' => 'required',
        ])) {
            $kategori = Kategorie::where(['id' => $request->id])->first();
            $kategori->update([
                'kategori' =>  $request->kategori,
            ]);

            $request->session()->flash('success', 'Kategori berhasil diupdate');
            return redirect()->route('kategori.edit', ['id' => $kategori['id']]);
        }
    }

    //method post delete kategori
    public function delete(Request $request)
    {
        // SELECT * FROM kategori WHERE id = $id ;
        $kategori = Kategorie::find($request->id);

        //delete kategori
        if ($kategori->delete()) {
            $request->session()->flash('success', "Kategori berhasil di Delete");
            return redirect()->route('kategori');
        }
    }
}
