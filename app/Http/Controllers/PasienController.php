<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Patients',
            'sidebar' => 'Patients',
            'user' => $user,
            'pasiens' => User::where(['level_role' => 'pasien'])->get(),
        ];
        return view('admin.patients', $data);
    }

    public function add()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Add Patients',
            'sidebar' => 'Patients',
            'user' => $user,
        ];
        return view('admin.patients-add', $data);
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
            $user->level_role = 'pasien';
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

            $request->session()->flash('success', 'Akun Pasien Berhasil dibuat');
            return redirect()->route('patients.add');
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $pasien = User::where(['id' => $id])->first();
        $data = [
            'title' => $pasien->name,
            'sidebar' => 'Patients',
            'user' => $user,
            'pasien' => $pasien,
        ];
        return view('admin.patients-edit', $data);
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
                $request->session()->flash('success', 'Informasi Pasien Berhasil diupdate');
                return redirect()->route('patients.edit', ['id' => $request->id]);
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
                    return redirect()->route('patients.edit', ['id' => $request->id, 'change-password']);
                }
            }
        }
        return redirect()->route('patients.edit', ['id' => $request->id]);
    }

    public function delete(Request $request)
    {
        $dokter = User::find($request->id);
        if (!empty($dokter->image_profile)) {
            unlink(public_path('uploads/images/user/') . $dokter->image_profile);
        }

        if ($dokter->delete()) {
            $request->session()->flash('success', "Pasien berhasil di Delete");
            return redirect()->route('patients');
        }
    }
}
