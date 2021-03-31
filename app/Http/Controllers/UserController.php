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

    public function profile()
    {
        $data = [
            'title' => 'Profile',
            'sidebar' => 'Profile',
            'user' => $this->userModel->where(['id' => session('user_id')])->first()
        ];
        return view('profile', $data);
    }

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

    public function updateProfile(Request $request)
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
                'provinces_id' => $request->province,
                'cities_id' => $request->city,
                'districts_id' => $request->district,
                'alamat' => $request->alamat,
                'gender' => $request->gender,
                'image_profile' => $fileName,
                'pengalaman' => $request->pengalaman,
                'info' => $request->info,
            ])) {
                $request->session()->flash('success', 'Profile Berhasil diupdate');
                return redirect('profile');
            }
        }
    }

    public function updateAccount(Request $request)
    {
        $user = User::find($request->id);

        if (empty($request->oldpass)) {
            $request->validate([
                'email' => 'required|email'
            ]);

            $user->update([
                'email' =>  $request->email,
            ]);

            $request->session()->flash('success', 'Email Berhasil diupdate');
            return redirect()->route('profile');
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
                    ]);

                    $request->session()->flash('success', 'Password berhasil di ubah');
                    return redirect()->route('profile');
                } else {
                    $request->session()->flash('danger', "Password lama salah");
                    return redirect('profile/edit?change-password');
                }
            }
        }
    }
}
