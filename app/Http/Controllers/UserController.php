<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Models\Province;

class UserController extends Controller
{
    public function __construct()
    {
        $this->userModel = new User();
    }

    // method halaman dashboard dokter
    public function index()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Dashboard',
            'sidebar' => 'Dashboard',
            'user' => $user
        ];
        return view('dokter.dashboard', $data);
    }

    // method halaman profile
    public function profile()
    {
        $data = [
            'title' => 'Profile',
            'sidebar' => 'Profile',
            'user' => $this->userModel->where(['id' => session('user_id')])->first()
        ];
        return view('profile', $data);
    }

    // method halaman edit profile
    public function editProfile()
    {
        $data = [
            'title' => 'Edit Profile',
            'sidebar' => 'Profile',
            'user' => $this->userModel->where(['id' => session('user_id')])->first(),
            'provinces' => Province::pluck('name', 'id')
        ];
        return view('edit-profile', $data);
    }

    // method post update profile
    public function updateProfile(Request $request)
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
                'provinces_id' => $request->province,
                'cities_id' => $request->city,
                'districts_id' => $request->district,
                'alamat' => $request->alamat,
                'gender' => $request->gender,
                'image_profile' => $fileName,
                'pengalaman' => $request->pengalaman,
                'info' => $request->info,
            ])) {
                //kembali dengan membawa notifikasi
                $request->session()->flash('success', 'Profile Berhasil diupdate');
                return redirect('profile');
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
                'email' => 'required|email'
            ]);

            //update user
            $user->update([
                'email' =>  $request->email,
            ]);

            //kembali dengan membawa notifikasi
            $request->session()->flash('success', 'Email Berhasil diupdate');
            return redirect()->route('profile');

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
                    ]);
                    //kembali dengan membawa notifikasi
                    $request->session()->flash('success', 'Password berhasil di ubah');
                    return redirect()->route('profile');
                } else {
                    //kembali dengan membawa notifikasi gagal
                    $request->session()->flash('danger', "Password lama salah");
                    return redirect('profile/edit?change-password');
                }
            }
        }
    }
}
