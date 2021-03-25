<?php

namespace App\Http\Controllers;

use App\Models\Kategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
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

    public function create(Request $request)
    {

        if ($request->validate([
            'kategori' => 'required|unique:kategories,kategori',
        ])) {

            $kategori = new Kategorie;
            $kategori->kategori = $request->kategori;
            $kategori->save();

            $request->session()->flash('success', ' Kategori ' . $request->kategori . ' berhasil ditambahkan');
            return redirect()->route('kategori');
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $kategori = Kategorie::where(['id' => $id])->first();

        $data = [
            'title' => ' Kategori Edit',
            'sidebar' => 'Kategori',
            'user' => $user,
            'kategori' =>  $kategori,
        ];
        return view('admin.kategori-edit', $data);
    }
    public function update(Request $request)
    {
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

    public function delete(Request $request)
    {
        $kategori = Kategorie::find($request->id);

        if ($kategori->delete()) {
            $request->session()->flash('success', "Kategori berhasil di Delete");
            return redirect()->route('kategori');
        }
    }
}
