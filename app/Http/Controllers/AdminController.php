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
    public function dashboard()
    {
        $user = Auth::user();

        $this->booking = new Booking();
        $dokter = User::where(['level_role' => 'dokter']);
        $pasien = User::where(['level_role' => 'pasien']);

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

    public function index()
    {
        $user = Auth::user();

        $admins = User::where(['level_role' => 'admin'])->get();

        $data = [
            'title' => 'Admin Users',
            'sidebar' => 'Admin',
            'user' => $user,
            'admins' => $admins,
        ];
        return view('admin.admin', $data);
    }

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

    public function create(Request $request)
    {

        if ($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required| min:6',
            'password_match' => 'required| same:password',
            'telp' => ['required', new phoneindo],
        ])) {

            if ($request->image_profile) {
                $request->validate([
                    'image_profile' => 'image:jpg,png,jpeg|max:2048'
                ]);
                $fileName = time() . '_' . $request->image_profile->getClientOriginalName();
                $request->image_profile->move(public_path('uploads/images/user/'), $fileName);
            } else {
                $fileName = null;
            }

            $ttl = date('Y-m-d', strtotime(str_replace('/', '-', $request->ttl)));

            $birthDate = new DateTime($ttl);
            $today = new DateTime("today");
            if ($birthDate > $today) {
                $umur = 0;
            }
            $umur = $today->diff($birthDate)->y;

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

            $request->session()->flash('success', 'Akun Admin Berhasil dibuat');
            return redirect()->route('admin.add');
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $admin = User::where(['id' => $id])->first();
        $data = [
            'title' => $admin->name,
            'sidebar' => 'Admin',
            'user' => $user,
            'admin' => $admin,
        ];
        return view('admin.admin-edit', $data);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        if ($request->validate([
            'name' => 'required',
            'telp' => ['required', new phoneindo],
            'image_profile' => 'image:jpeg,png,jpg|max:2048',
        ])) {

            if ($request->image_profile) {
                $fileName = time() . '_' . $request->image_profile->getClientOriginalName();
                if ($request->image_profile->move(public_path('uploads/images/user'), $fileName)) {
                    if ($user->image_profile !== null) {
                        unlink(public_path('uploads/images/user/') . $user->image_profile);
                    }
                }
            } else {
                $fileName = $user->image_profile;
            }

            $ttl = date('Y-m-d', strtotime(str_replace('/', '-', $request->ttl)));

            $birthDate = new DateTime($ttl);
            $today = new DateTime("today");
            if ($birthDate > $today) {
                $umur = 0;
            }
            $umur = $today->diff($birthDate)->y;

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
                $request->session()->flash('success', 'Informasi Admin Berhasil diupdate');
                return redirect()->route('admin.edit', ['id' => $request->id]);
            }
        }
    }

    public function updateAccount(Request $request)
    {
        $user = User::find($request->id);

        if (empty($request->oldpass)) {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user->update([
                'email' =>  $request->email,
                'status_akun' => $request->status
            ]);

            $request->session()->flash('success', 'Akun Berhasil diupdate');
        } else {

            if ($request->validate([
                'email' => 'required',
                'oldpass' => 'required',
                'newpass' => 'required|min:6'
            ])) {

                if (Hash::check($request->oldpass, $user->password)) {

                    $user->update([
                        'email' =>  $request->email,
                        'password' =>  bcrypt($request->newpass),
                        'status_akun' => $request->status
                    ]);

                    $request->session()->flash('success', 'Password berhasil di ubah');
                } else {
                    $request->session()->flash('danger', "Password lama salah");
                    return redirect()->route('admin.edit', ['id' => $request->id, 'change-password']);
                }
            }
        }
        return redirect()->route('admin.edit', ['id' => $request->id]);
    }

    public function delete(Request $request)
    {
        $dokter = User::find($request->id);
        if (!empty($dokter->image_profile)) {
            unlink(public_path('uploads/images/user/') . $dokter->image_profile);
        }

        if ($dokter->delete()) {
            $request->session()->flash('success', "Admin berhasil di Delete");
            return redirect()->route('admin.users');
        }
    }
}
