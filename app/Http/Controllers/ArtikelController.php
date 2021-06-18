<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    //method halaman list artikel
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
    //method halaman form  artikel baru
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
    //method post buat artikel baru
    public function create(Request $request)
    {
        //check validasi form
        if ($request->validate([
            'title' => 'required',
            'kategori' => 'required',
            'isi' => 'required',
            'image' => 'required|image:jpg,png,jpeg|max:2048',
        ])) {

            //set file image name 
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            // simpan file image public/upload/images/artikel/
            $request->image->move(public_path('uploads/images/artikel/'), $fileName);

            //simpan artikel baru
            $artikel = new Artikel();
            $artikel->id_admin = $request->id_admin;
            $artikel->judul = $request->title;
            $artikel->id_kategori = $request->kategori;
            $artikel->image = $fileName;
            $artikel->isi = $request->isi;
            $artikel->status = $request->status;
            $artikel->save();

            //kembali dengan notifikasi
            $request->session()->flash('success', 'Artikel Berhasil dibuat');
            return redirect()->route('artikel.add');
        }
    }

    //method halaman artikel by id
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

    //method edit artikel by id 
    public function edit($id)
    {
        $user = Auth::user();
        // SELECT * FROM artikel WHERE id = $id  LIMIT 1;
        $artikel = Artikel::where(['id' => $id])->first();
        // SELECT * FROM kategori ;
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

    //method post update artikel 
    public function update(Request $request)
    {
        // SELECT * FROM artikel WHERE id = $id  LIMIT 1;
        $artikel = Artikel::where(['id' => $request->id])->first();

        //check validasi form
        if ($request->validate([
            'title' => 'required',
            'kategori' => 'required',
            'isi' => 'required',
            'image' => 'image:jpg,png,jpeg|max:2048',
        ])) {
            //check apakah file image profile di input 
            if ($request->image) {
                //set nama file image baru
                $fileName = time() . '_' . $request->image->getClientOriginalName();
                //simpan file image ke folder public/uploads/artikel/
                if ($request->image->move(public_path('uploads/images/artikel'), $fileName)) {
                    //check apakah file image sebelumnya tidak kosong
                    if ($artikel->image !== null) {
                        //delete file image sebelumnya
                        unlink(public_path('uploads/images/artikel/') . $artikel->image);
                    }
                }
            } else {
                //set nama file image tetap nama yang lama
                $fileName = $artikel->image;
            }

            //update artikel
            if ($artikel->update([
                'id_admin' => $request->id_admin,
                'judul' => $request->title,
                'id_kategori' => $request->kategori,
                'image' => $fileName,
                'isi' => $request->isi,
                'status' => $request->status,
            ])) {
                //kembali dengan membawa notifikasi
                $request->session()->flash('success', 'Artikel Berhasil diupdate');
                return redirect()->route('artikel.edit', ['id' => $request->id]);
            }
        }
    }

    // method post delete artikel 
    public function delete(Request $request)
    {
        //cari artikel dengan id berdasarkan request
        $artikel = Artikel::find($request->id);

        //check apakah image  tidak null, jika tidak null delete file image 
        if (!empty($artikel->image)) {
            unlink(public_path('uploads/images/artikel/') . $artikel->image);
        }
        //delete artikel
        if ($artikel->delete()) {
            // kembali dengan notifikasi 
            $request->session()->flash('success', "Artikel berhasil di Delete");
            return redirect()->route('artikel');
        }
    }
}
