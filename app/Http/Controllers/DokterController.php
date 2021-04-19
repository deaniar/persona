<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Review;
use App\Models\Booking;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Models\Province;

class DokterController extends Controller
{
    public function __construct()
    {
        $this->userModel = new User();
        $this->BookingModel = new Booking();
    }

    public function index()
    {
        $user = Auth::user();
        $data = [
            'title' => 'doctors',
            'sidebar' => 'Doctors',
            'user' => $user,
            'doctors' => $this->userModel->where(['level_role' => 'dokter'])->get(),
        ];
        return view('admin.doctors', $data);
    }

    public function add()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Add Doctor',
            'sidebar' => 'Doctors',
            'user' => $user,
            'provinces' => Province::pluck('name', 'id')
        ];
        return view('admin.doctors-add', $data);
    }

    public function create(Request $request)
    {
        if ($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required| min:6',
            'password_match' => 'required| same:password',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
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
            $user->level_role = 'dokter';
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
            $user->pengalaman = $request->pengalaman;
            $user->info = $request->info;
            $user->status_akun = $request->status;
            $user->save();

            $request->session()->flash('success', 'Akun Dokter Berhasil dibuat');
            return redirect('doctors/add');
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $dokter = User::where(['level_role' => 'dokter', 'id' => $id])->first();

        $sum_skor = Review::where(['id_dokter' => $id])->sum('skor');
        $count_review = Review::where(['id_dokter' => $id])->count();

        $data = [
            'title' => $dokter->name,
            'sidebar' => 'Doctors',
            'user' => $user,
            'dokter' => $dokter,
            'total_pasien' => Booking::where(['id_dokter' => $id])->whereNotIn('status_booking', ['konfirmasi'])->count(),
            'jadwals' => Jadwal::where(['id_dokter' => $id])->get(),
            'skor' => ($sum_skor && $count_review) ?  ($sum_skor / $count_review) : null,
            'sudah_konfirmasi' => $this->BookingModel->getDataBooking($id, ['terima', 'selesai'])
        ];
        return view('admin.doctor-show', $data);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dokter = User::where(['level_role' => 'dokter', 'id' => $id])->first();
        $data = [
            'title' => $dokter->name . ' | Edit Data',
            'sidebar' => 'Doctors',
            'user' => $user,
            'dokter' => $dokter,
            'provinces' => Province::pluck('name', 'id')
        ];
        return view('admin.doctor-edit', $data);
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
                'provinces_id' => $request->province,
                'cities_id' => $request->city,
                'districts_id' => $request->district,
                'alamat' => $request->alamat,
                'gender' => $request->gender,
                'image_profile' => $fileName,
                'pengalaman' => $request->pengalaman,
                'info' => $request->info,
            ])) {
                $request->session()->flash('success', 'Informasi Dokter Berhasil diupdate');
                return redirect()->route('doctors.edit', ['id' => $request->id]);
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
                    return redirect('doctors/' . $request->id . '/edit?change-password');
                }
            }
        }
        return redirect()->route('doctors.edit', ['id' => $request->id]);
    }

    public function delete(Request $request)
    {
        $dokter = User::find($request->id);
        if (!empty($dokter->image_profile)) {
            unlink(public_path('uploads/images/user/') . $dokter->image_profile);
        }

        if ($dokter->delete()) {
            $request->session()->flash('success', "Dokter berhasil di Delete");
            return redirect()->route('doctors');
        }
    }
}
