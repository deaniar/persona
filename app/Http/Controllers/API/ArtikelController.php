<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategorie;
use App\Models\User;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->ArtikelModel = new Artikel();
    }

    public function index()
    {
        $data = Artikel::get();
        foreach ($data as $d) {
            $datas[] = $this->ArtikelModel->getDataArtikelbyAPI($d->id);
        }
        return response()->json($datas, 200);
    }
    public function show($id)
    {


        return response()->json($this->ArtikelModel->getDataArtikelbyAPI($id), 200);
    }

    public function create(Request $request)
    {
        if ($request->validate([
            'id_admin' => 'required',
            'judul' => 'required',
            'id_kategori' => 'required',
            'image' => 'required|image:jpeg,png,jpg|max:2048',
            'isi' => 'required'
        ])) {

            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/artikel'), $fileName);

            $artikel = new Artikel;
            $artikel->id_admin = $request->id_admin;
            $artikel->judul = $request->judul;
            $artikel->id_kategori = $request->id_kategori;
            $artikel->image = $fileName;
            $artikel->isi = $request->isi;
            $artikel->save();

            return response()->json([
                'messege' => 'Artikel berhasil dipost',
                'data' => $artikel
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = Artikel::where(['id' => $id])->first();
        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $artikel = Artikel::find($request->id);
        if ($request->validate([
            'id_admin' => 'required',
            'judul' => 'required',
            'id_kategori' => 'required',
            'image' => 'required|image:jpeg,png,jpg|max:2048',
            'isi' => 'required'
        ])) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            if ($request->image->move(public_path('uploads/images/artikel'), $fileName)) {
                unlink(public_path('uploads/images/artikel/') . $artikel->image);
            }

            if ($artikel->update([
                'id_admin' => $request->id_admin,
                'judul' => $request->judul,
                'id_kategori' => $request->id_kategori,
                'image' => $fileName,
                'isi' => $request->isi
            ])) {

                return response()->json([
                    'messege' => 'Artikel berhasil diupdate',
                    'data' => $artikel
                ], 200);
            }
        }
    }

    public function delete(Request $request)
    {
        $artikel = Artikel::find($request->id);
        unlink(public_path('uploads/images/artikel/') . $artikel->image);

        if ($artikel->delete()) {
            return response()->json([
                'message' => 'Artikel berhasil dihapus',
            ], 200);
        }
    }
}
