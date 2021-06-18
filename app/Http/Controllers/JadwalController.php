<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index($id_dokter)
    {
        $user = Auth::user();
        //jika level_role user login == admin atau user id = $id_dokter from parameter url
        if ($user->level_role == 'admin' || $user->id == $id_dokter) {
            // SELECT * FROM user WHERE level_role = 'dokter' OR id = $id_dokter LIMIT 1;
            $dokter = User::where(['level_role' => 'dokter', 'id' => $id_dokter])->first();
            //SELECT * FROM jadwal WHERE id_dokter = $id_dokter ORDER BY hari DESC;
            $jadwals = Jadwal::where(['id_dokter' => $id_dokter])->orderBy('hari', 'DESC')->get();

            //SET array days untuk dropdown form pada halaman dokter jadwal;
            $days = array('senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu');
            $data = [
                'title' => ' Jadwal',
                'sidebar' => ($user->level_role == 'admin') ? 'Doctors' : 'Schedule',
                'user' => $user,
                'dokter' => $dokter,
                'jadwals' =>  $jadwals,
                'days' => $days
            ];
            return view('jadwal.dokter-jadwal', $data);
        } else {
            return redirect()->route('dokter');
        }
    }

    //method post buat jadwal baru
    public function create(Request $request)
    {
        //check validasi form
        if ($request->validate([
            'id_dokter' => 'required',
            'hari' => 'required',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
        ])) {

            //check jadwal dengan hari yang sama apakah sudah ada ?
            if (Jadwal::where(['id_dokter' => $request->id_dokter, 'hari' => $request->hari])->first()) {
                $request->session()->flash('danger', 'Jadwal hari ' . $request->hari . ' sudah ada');
                return redirect()->route('jadwal', ['id' => $request->id_dokter, 'add']);
            } else {

                //check jika jadwal tutup lebih kecil dari jam buka, misal jam tutup 08.00 jam buka 16.00?
                if ($request->jam_tutup <= $request->jam_buka) {
                    $request->session()->flash('danger', 'Input jam tidak benar');
                    return redirect()->route('jadwal', ['id' => $request->id_dokter, 'add']);
                }

                //simpan data jadwal ke database
                $jadwal = new Jadwal;
                $jadwal->id_dokter = $request->id_dokter;
                $jadwal->hari = $request->hari;
                $jadwal->jam_buka = $request->jam_buka;
                $jadwal->jam_tutup = $request->jam_tutup;
                $jadwal->save();
                //kebali dengan notfikiasi
                $request->session()->flash('success', 'Jadwal hari ' . $request->hari . ' berhasil ditambahkan');
                return redirect()->route('jadwal', ['id' => $request->id_dokter, 'add']);
            }
        }
    }

    //method halaman edit jadwal by jadwal dan by id dokter dari parameter url
    public function edit($id_dokter, $id_jadwal)
    {
        $user = Auth::user();
        $jadwal = Jadwal::where(['id' => $id_jadwal])->first();
        $days = array('senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu');

        $data = [
            'title' => ' Jadwal Edit',
            'sidebar' => ($user->level_role == 'admin') ? 'Doctors' : 'Schedule',
            'user' => $user,
            'jadwal' =>  $jadwal,
            'id_dokter' => $id_dokter,
            'days' => $days
        ];
        return view('jadwal.dokter-jadwal-edit', $data);
    }

    //method update jadwal 
    public function update(Request $request)
    {
        // check validasi form
        if ($request->validate([
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
        ])) {

            $jadwal = Jadwal::where(['id' => $request->id])->first();
            //check jika jadwal tutup lebih kecil dari jam buka, misal jam tutup 08.00 jam buka 16.00?
            if ($request->jam_tutup <= $request->jam_buka) {
                $request->session()->flash('danger', 'Input jam tidak benar');
                return redirect()->route('jadwal.edit', ['id_dokter' => $jadwal['id_dokter'], 'id_jadwal' => $jadwal['id']]);
            }

            //update jadwal
            $jadwal->update([
                'jam_buka' =>  $request->jam_buka,
                'jam_tutup' => $request->jam_tutup
            ]);

            //kembali dengan notifikasi
            $request->session()->flash('success', 'Jadwal berhasil diupdate');
            return redirect()->route('jadwal.edit', ['id_dokter' => $jadwal['id_dokter'], 'id_jadwal' => $jadwal['id']]);
        }
    }

    //method delete jadwal 
    public function delete(Request $request)
    {
        $jadwal = Jadwal::find($request->id);

        if ($jadwal->delete()) {
            $request->session()->flash('success', "Jadwal berhasil di Delete");
            return redirect()->route('jadwal', ['id' => $jadwal->id_dokter]);
        }
    }
}
