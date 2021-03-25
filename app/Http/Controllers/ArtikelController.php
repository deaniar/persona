<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Artikel',
            'sidebar' => 'Artikel',
            'user' => $user,
            'artikels' => Artikel::all(),
        ];
        return view('admin.artikel', $data);
    }

    public function add()
    {
        $user = Auth::user();
        $kategories = Kategorie::all();
        $data = [
            'title' => 'Add Artikel',
            'sidebar' => 'Artikel',
            'user' => $user,
            'kategories' => $kategories
        ];

        return view('admin.artikel-add', $data);
    }

    public function create(Request $request)
    {
        if ($request->validate([
            'title' => 'required',
            'kategori' => 'required',
            'isi' => 'required',
            'image' => 'required|image:jpg,png,jpeg|max:2048',
        ])) {

            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/artikel/'), $fileName);


            $artikel = new Artikel();
            $artikel->id_admin = $request->id_admin;
            $artikel->judul = $request->title;
            $artikel->id_kategori = $request->kategori;
            $artikel->image = $fileName;
            $artikel->isi = $request->isi;
            $artikel->status = $request->status;
            $artikel->save();

            $request->session()->flash('success', 'Artikel Berhasil dibuat');
            return redirect()->route('artikel.add');
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $this->artikelModel = new Artikel();
        $artikel = $this->artikelModel->getDataArtikel(['id' => $id]);

        $data = [
            'title' => $artikel[0]->judul,
            'sidebar' => 'artikel',
            'user' => $user,
            'artikel' => $artikel[0],
        ];
        return view('admin.artikel-show', $data);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $artikel = Artikel::where(['id' => $id])->first();
        $kategories = Kategorie::all();
        $data = [
            'title' => 'Edit Artikel | ' . $artikel->judul,
            'sidebar' => 'artikel',
            'user' => $user,
            'artikel' => $artikel,
            'kategories' => $kategories
        ];

        return view('admin.artikel-edit', $data);
    }

    public function update(Request $request)
    {
        $artikel = Artikel::where(['id' => $request->id])->first();

        if ($request->validate([
            'title' => 'required',
            'kategori' => 'required',
            'isi' => 'required',
            'image' => 'image:jpg,png,jpeg|max:2048',
        ])) {

            if ($request->image) {
                $fileName = time() . '_' . $request->image->getClientOriginalName();
                if ($request->image->move(public_path('uploads/images/artikel'), $fileName)) {
                    if ($artikel->image !== null) {
                        unlink(public_path('uploads/images/artikel/') . $artikel->image);
                    }
                }
            } else {
                $fileName = $artikel->image;
            }

            if ($artikel->update([
                'id_admin' => $request->id_admin,
                'judul' => $request->title,
                'id_kategori' => $request->kategori,
                'image' => $fileName,
                'isi' => $request->isi,
                'status' => $request->status,
            ])) {
                $request->session()->flash('success', 'Artikel Berhasil diupdate');
                return redirect()->route('artikel.edit', ['id' => $request->id]);
            }
        }
    }

    public function delete(Request $request)
    {
        $artikel = Artikel::find($request->id);
        if (!empty($artikel->image)) {
            unlink(public_path('uploads/images/artikel/') . $artikel->image);
        }

        if ($artikel->delete()) {
            $request->session()->flash('success', "Artikel berhasil di Delete");
            return redirect()->route('artikel');
        }
    }
}
