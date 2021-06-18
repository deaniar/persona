<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Booking;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // method halaman dashboard admin
    public function dashboard()
    {
        $user = Auth::user();

        //diambil dari model booking
        $this->booking = new Booking();
        // select * from user where level_role = dokter
        $dokter = User::where(['level_role' => 'dokter']);
        // select * from user where level_role = pasien
        $pasien = User::where(['level_role' => 'pasien']);

        // data yang diperlukan pada halaman dashboard admin
        $data = [
            'title' => 'Dashboard',
            'sidebar' => 'Dashboard',
            'user' => $user,
            'dokter' => $dokter->get(),
            'appointments' =>  $this->booking->getDataBookingAll(),
            'count_dokter' => $dokter->count(),
            'count_pasien' => $pasien->count(),
            'count_terkonfirmasi' => Booking::where(['status_booking' => 'terima'])->count(),
            'count_pending' => Booking::where(['status_booking' => 'konfirmasi'])->count()
        ];
        return view('admin.dashboard', $data);
    }

    // method halaman list admin users
    public function index()
    {
        $user = Auth::user();
        // select * from user where level_role = admin
        $admins = User::where(['level_role' => 'admin'])->get();

        // data yang diperlukan pada halaman list admin users
        $data = [
            'title' => 'Admin Users',
            'sidebar' => 'Admin',
            'user' => $user,
            'admins' => $admins,
        ];

        return view('admin.admin', $data);
    }

    // method halaman tambah admin
    public function add()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Add Admin',
            'sidebar' => 'Admin',
            'user' => $user,
        ];
        return view('admin.admin-add', $data);
    }

    // method post buat admin baru
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
            $umur = $today->diff($birthDate)->y;

            //buat user admin baru simpan kedalam database
            $user = new User();
            $user->level_role = 'admin';
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->name = $request->name;
            $user->telp = $request->telp;
            $user->umur  = $umur;
            $user->ttl = $ttl;
            $user->alamat = $request->alamat;
            $user->gender = $request->gender;
            $user->image_profile = $fileName;
            $user->status_akun = $request->status;
            $user->save();

            //kembali dengan membawa notifikasi
            $request->session()->flash('success', 'Akun Admin Berhasil dibuat');
            return redirect()->route('admin.add');
        }
    }

    // method halaman edit admin
    public function edit($id)
    {
        $user = Auth::user();
        //select * user where id = id (id dari parameter id pada url)
        $admin = User::where(['id' => $id])->first();
        $data = [
            'title' => $admin->name,
            'sidebar' => 'Admin',
            'user' => $user,
            'admin' => $admin,
        ];
        return view('admin.admin-edit', $data);
    }

    // method post update admin
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
                'umur' => $request->umur,
                'umur' => $umur,
                'ttl' => $ttl,
                'alamat' => $request->alamat,
                'gender' => $request->gender,
                'image_profile' => $fileName,
            ])) {
                //kembali dengan membawa notifikasi
                $request->session()->flash('success', 'Informasi Admin Berhasil diupdate');
                return redirect()->route('admin.edit', ['id' => $request->id]);
            }
        }
    }

    // method post update akun admin email dan password
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
                    //kembali dengan membawa notifikasi gagal
                    $request->session()->flash('danger', "Password lama salah");
                    return redirect()->route('admin.edit', ['id' => $request->id, 'change-password']);
                }
            }
        }
        return redirect()->route('admin.edit', ['id' => $request->id]);
    }

    // method post delete akun admin
    public function delete(Request $request)
    {
        //cari user dengan id berdasarkan request
        $admin = User::find($request->id);

        //check apakah image profile tidak null, jika tidak null delete file image user
        if (!empty($admin->image_profile)) {

            unlink(public_path('uploads/images/user/') . $admin->image_profile);
        }

        //delete user
        if ($admin->delete()) {
            // kembali dengan notifikasi 
            $request->session()->flash('success', "Admin berhasil di Delete");
            return redirect()->route('admin.users');
        }
    }
}
