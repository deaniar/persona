<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Models\Province;

class PasienController extends Controller
{
    // method halaman list pasien users
    public function index()
    {
        $user = Auth::user();

        // data yang diperlukan pada halaman list pasien users
        $data = [
            'title' => 'Patients',
            'sidebar' => 'Patients',
            'user' => $user,
            'pasiens' => User::where(['level_role' => 'pasien'])->get(),
        ];
        return view('admin.patients', $data);
    }

    // method halaman tambah pasien
    public function add()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Add Patients',
            'sidebar' => 'Patients',
            'user' => $user,
            'provinces' => Province::pluck('name', 'id')
        ];
        return view('admin.patients-add', $data);
    }

    // method post buat pasien baru
    public function create(Request $request)
    {
        //check validasi input form
        if ($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required| min:6',
            'password_match' => 'required| same:password',
            'telp' => ['required', new phoneindo],
        ])) {
            //check apakah file image profile di input 
            if ($request->image_profile) {
                //jika di input check validasi file image
                $request->validate([
                    'image_profile' => 'image:jpg,png,jpeg|max:2048'
                ]);
                //set ulang nama file
                $fileName = time() . '_' . $request->image_profile->getClientOriginalName();
                //simpan file image ke folder public/uploads/images/user
                $request->image_profile->move(public_path('uploads/images/user/'), $fileName);
            } else {
                $fileName = null;
            }
            //set tanggal lahir format Y-m-d
            $ttl = date('Y-m-d', strtotime(str_replace('/', '-', $request->ttl)));
            //set umur
            $birthDate = new DateTime($ttl);
            $today = new DateTime("today");
            if ($birthDate > $today) {
                $umur = 0;
            }

            //buat user  baru simpan kedalam database
            $user = new User();
            $user->level_role = 'pasien';
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->name = $request->name;
            $user->telp = $request->telp;
            $user->umur  = $umur;
            $user->ttl = $ttl;
            $user->provinces_id = $request->province;
            $user->cities_id = $request->city;
            $user->districts_id = $request->district;
            $user->alamat = $request->alamat;
            $user->gender = $request->gender;
            $user->image_profile = $fileName;
            $user->status_akun = $request->status;
            $user->save();
            //kembali dengan membawa notifikasi
            $request->session()->flash('success', 'Akun Pasien Berhasil dibuat');
            return redirect()->route('patients.add');
        }
    }

    // method halaman edit pasien
    public function edit($id)
    {
        $user = Auth::user();
        //select * user where id = id (id dari parameter id pada url)
        $pasien = User::where(['id' => $id])->first();
        $data = [
            'title' => $pasien->name,
            'sidebar' => 'Patients',
            'user' => $user,
            'pasien' => $pasien,
            'provinces' => Province::pluck('name', 'id')
        ];
        return view('admin.patients-edit', $data);
    }

    // method post update pasien
    public function update(Request $request)
    {
        //select * user where id = id (id dari request id pada form method post)
        $user = User::find($request->id);
        // check validasi form
        if ($request->validate([
            'name' => 'required',
            'telp' => ['required', new phoneindo],
            'image_profile' => 'image:jpeg,png,jpg|max:2048',
        ])) {
            //check apakah file image profile di input 
            if ($request->image_profile) {
                //set nama file image baru
                $fileName = time() . '_' . $request->image_profile->getClientOriginalName();
                //simpan file image ke folder public/uploads/images/user
                if ($request->image_profile->move(public_path('uploads/images/user'), $fileName)) {
                    //check apakah file image sebelumnya tidak kosong
                    if ($user->image_profile !== null) {
                        //delete file image sebelumnya
                        unlink(public_path('uploads/images/user/') . $user->image_profile);
                    }
                }
            } else {
                //set nama file image tetap nama yang lama
                $fileName = $user->image_profile;
            }

            //set tanggal lahir format Y-m-d
            $ttl = date('Y-m-d', strtotime(str_replace('/', '-', $request->ttl)));
            //set umur
            $birthDate = new DateTime($ttl);
            $today = new DateTime("today");
            if ($birthDate > $today) {
                $umur = 0;
            }
            $umur = $today->diff($birthDate)->y;

            //update user
            if ($user->update([
                'name' => $request->name,
                'telp' => $request->telp,
                'umur' => $umur,
                'ttl' => $ttl,
                'provinces_id' => $request->province,
                'cities_id' => $request->city,
                'districts_id' => $request->district,
                'alamat' => $request->alamat,
                'gender' => $request->gender,
                'image_profile' => $fileName,
            ])) {
                //kembali dengan membawa notifikasi
                $request->session()->flash('success', 'Informasi Pasien Berhasil diupdate');
                return redirect()->route('patients.edit', ['id' => $request->id]);
            }
        }
    }
    // method post update akun pasien email dan password
    public function updateAccount(Request $request)
    {
        //select * user where id = id (id dari request id pada form method post)
        $user = User::find($request->id);

        //check jika password lama terisi atau tidak, hanya update email dan status akun saja
        if (empty($request->oldpass)) {
            //check validasi email
            $request->validate([
                'email' => 'required|email',
            ]);
            //update user
            $user->update([
                'email' =>  $request->email,
                'status_akun' => $request->status
            ]);
            //kembali dengan membawa notifikasi
            $request->session()->flash('success', 'Akun Berhasil diupdate');
            //update akun dengan password baru   
        } else {

            //check validasi form 
            if ($request->validate([
                'email' => 'required',
                'oldpass' => 'required',
                'newpass' => 'required|min:6'
            ])) {

                //check apakah password lama dimasukkan == password yang didatabase
                if (Hash::check($request->oldpass, $user->password)) {
                    //update user
                    $user->update([
                        'email' =>  $request->email,
                        'password' =>  bcrypt($request->newpass),
                        'status_akun' => $request->status
                    ]);
                    //kembali dengan membawa notifikasi
                    $request->session()->flash('success', 'Password berhasil di ubah');
                } else {
                    //kembali dengan membawa notifikasi
                    $request->session()->flash('danger', "Password lama salah");
                    return redirect()->route('patients.edit', ['id' => $request->id, 'change-password']);
                }
            }
        }
        return redirect()->route('patients.edit', ['id' => $request->id]);
    }
    // method post delete akun 
    public function delete(Request $request)
    {
        //cari user dengan id berdasarkan request
        $pasien = User::find($request->id);

        //check apakah image profile tidak null, jika tidak null delete file image user
        if (!empty($pasien->image_profile)) {
            unlink(public_path('uploads/images/user/') . $pasien->image_profile);
        }
        //delete user
        if ($pasien->delete()) {
            // kembali dengan notifikasi 
            $request->session()->flash('success', "Pasien berhasil di Delete");
            return redirect()->route('patients');
        }
    }
}
