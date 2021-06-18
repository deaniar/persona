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

    // method halaman list dokter users
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

    // method halaman tambah dokter
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

    // method post buat admin baru
    public function create(Request $request)
    {
        //check validasi input form
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
            //kembali dengan membawa notifikasi
            $request->session()->flash('success', 'Akun Dokter Berhasil dibuat');
            return redirect('doctors/add');
        }
    }

    // method halaman show dokter by id
    public function show($id)
    {
        $user = Auth::user();
        //select * user where id = id (id dari parameter id pada url)
        $dokter = User::where(['level_role' => 'dokter', 'id' => $id])->first();
        // SELECT SUM(skor) FROM review WHERE id_dokter = $id (id dari parameter id pada url);
        $sum_skor = Review::where(['id_dokter' => $id])->sum('skor');

        // SELECT COUNT(id) FROM review WHERE id_dokter = $id (id dari parameter id pada url);
        $count_review = Review::where(['id_dokter' => $id])->count();

        $data = [
            'title' => $dokter->name,
            'sidebar' => 'Doctors',
            'user' => $user,
            'dokter' => $dokter,
            'total_pasien' => Booking::where(['id_dokter' => $id])->whereNotIn('status_booking', ['konfirmasi'])->count(),
            'jadwals' => Jadwal::where(['id_dokter' => $id])->get(),
            // skor = sum_skor / count_reivew jika gak ada set null
            'skor' => ($sum_skor && $count_review) ?  ($sum_skor / $count_review) : null,
            'sudah_konfirmasi' => $this->BookingModel->getDataBooking($id, ['terima', 'selesai'])
        ];
        return view('admin.doctor-show', $data);
    }

    // method halaman edit dokter by id
    public function edit($id)
    {
        $user = Auth::user();
        //select * user where id = id (id dari parameter id pada url)

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
    // method post update dokter
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
                $request->session()->flash('success', 'Informasi Dokter Berhasil diupdate');
                return redirect()->route('doctors.edit', ['id' => $request->id]);
            }
        }
    }

    // method post update akun dokter email dan password
    public function updateAccount(Request $request)
    {
        //select * user where id = id (id dari request id pada form method post)
        $user = User::find($request->id);

        //check jika password lama terisi atau tidak, hanya update email dan status akun saja
        if (empty($request->oldpass)) {
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
                    return redirect('doctors/' . $request->id . '/edit?change-password');
                }
            }
        }
        return redirect()->route('doctors.edit', ['id' => $request->id]);
    }
    // method post delete akun dokter
    public function delete(Request $request)
    { //cari user dengan id berdasarkan request
        $dokter = User::find($request->id);
        //check apakah image profile tidak null, jika tidak null delete file image user
        if (!empty($dokter->image_profile)) {
            unlink(public_path('uploads/images/user/') . $dokter->image_profile);
        }
        //delete user
        if ($dokter->delete()) {
            // kembali dengan notifikasi 
            $request->session()->flash('success', "Dokter berhasil di Delete");
            return redirect()->route('doctors');
        }
    }
}
