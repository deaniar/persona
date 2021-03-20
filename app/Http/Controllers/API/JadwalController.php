<?php

namespace App\Http\Controllers\API;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    public function show($id)
    {
        $data = Jadwal::where(['id' => $id])->first();

        return response()->json([
            'id' => $data->id,
            'id_dokter' => $data->id_dokter,
            'hari' => $data->hari,
            'jam_buka' => $data->jam_buka,
            'jam_tutup' => $data->jam_tutup,
            'created_at' => $data->created_at
        ], 200);
    }

    public function jadwalByDokter($id_dokter)
    {
        $data = Jadwal::where('id_dokter', $id_dokter)->get();

        return response()->json($data, 200);
    }
}
