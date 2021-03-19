<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Review;
use App\Models\Booking;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function __construct()
    {
        $this->userModel = new User();
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
        $skor = ($sum_skor && $count_review) ?  ($sum_skor / $count_review) : null;

        $data = [
            'title' => $dokter->name,
            'sidebar' => 'Doctors',
            'user' => $user,
            'dokter' => $dokter,
            'total_pasien' => Booking::where(['id_dokter' => $id, 'status_booking' => 'terima'])->count(),
            'skor' => $skor,
        ];
        return view('admin.doctor-show', $data);
    }
}
