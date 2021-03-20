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
        if ($user->level_role == 'admin' || $user->id == $id_dokter) {
            $dokter = User::where(['level_role' => 'dokter', 'id' => $id_dokter])->first();
            $jadwals = Jadwal::where(['id_dokter' => $id_dokter])->orderBy('hari', 'DESC')->get();

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

    public function create(Request $request)
    {

        if ($request->validate([
            'id_dokter' => 'required',
            'hari' => 'required',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
        ])) {

            if (Jadwal::where(['id_dokter' => $request->id_dokter, 'hari' => $request->hari])->first()) {
                $request->session()->flash('danger', 'Jadwal hari ' . $request->hari . ' sudah ada');
                return redirect()->route('jadwal', ['id' => $request->id_dokter, 'add']);
            } else {

                if ($request->jam_tutup <= $request->jam_buka) {
                    $request->session()->flash('danger', 'Input jam tidak benar');
                    return redirect()->route('jadwal', ['id' => $request->id_dokter, 'add']);
                }

                $jadwal = new Jadwal;
                $jadwal->id_dokter = $request->id_dokter;
                $jadwal->hari = $request->hari;
                $jadwal->jam_buka = $request->jam_buka;
                $jadwal->jam_tutup = $request->jam_tutup;
                $jadwal->save();
                $request->session()->flash('success', 'Jadwal hari ' . $request->hari . ' berhasil ditambahkan');
                return redirect()->route('jadwal', ['id' => $request->id_dokter, 'add']);
            }
        }
    }

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

    public function update(Request $request)
    {
        if ($request->validate([
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
        ])) {
            $jadwal = Jadwal::where(['id' => $request->id])->first();
            if ($request->jam_tutup <= $request->jam_buka) {
                $request->session()->flash('danger', 'Input jam tidak benar');
                return redirect()->route('jadwal.edit', ['id_dokter' => $jadwal['id_dokter'], 'id_jadwal' => $jadwal['id']]);
            }

            $jadwal->update([
                'jam_buka' =>  $request->jam_buka,
                'jam_tutup' => $request->jam_tutup
            ]);

            $request->session()->flash('success', 'Jadwal berhasil diupdate');
            return redirect()->route('jadwal.edit', ['id_dokter' => $jadwal['id_dokter'], 'id_jadwal' => $jadwal['id']]);
        }
    }

    public function delete(Request $request)
    {
        $jadwal = Jadwal::find($request->id);

        if ($jadwal->delete()) {
            $request->session()->flash('success', "Jadwal berhasil di Delete");
            return redirect()->route('jadwal', ['id' => $jadwal->id_dokter]);
        }
    }
}
