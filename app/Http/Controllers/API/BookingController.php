<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class BookingController extends Controller
{
    public function index()
    {
        $data = Booking::get();
        return response()->json($data, 200);
    }

    public function create(Request $request)
    {

        if ($request->validate([
            'id_dokter' => 'required',
            'id_pasien' => 'required',
            'tgl_booking' => 'required',
        ])) {
            $booking = new Booking;
            $booking->id_dokter = $request->id_dokter;
            $booking->id_pasien = $request->id_pasien;
            $booking->tgl_booking = $request->tgl_booking;
            $booking->status_booking = 'konfirmasi';
            $booking->save();

            return response()->json([
                'message' => 'booking berhasil dibuat',
                'data' => $booking
            ], 200);
        }
    }

    public function show($id)
    {
        $booking = Booking::where(['id' => $id])->first();

        $data = [
            'id' => $booking->id,
            'dokter' => User::where(['id' => $booking->id_dokter])->first(),
            'pasien' => User::where(['id' => $booking->id_pasien])->first(),
            'tgl_booking' => $booking->tgl_booking,
            'status_booking' => $booking->status_booking,
            'created_at' => $booking->created_at,
            'updated_at' => $booking->updated_at
        ];

        return response()->json($data, 200);
    }

    public function edit($id)
    {
        $booking = Booking::where(['id' => $id])->first();
        $data = [
            'id' => $booking->id,
            'dokter' => User::where(['id' => $booking->id_dokter])->first(),
            'pasien' => User::where(['id' => $booking->id_pasien])->first(),
            'tgl_booking' => $booking->tgl_booking,
            'status_booking' => $booking->status_booking,
            'created_at' => $booking->created_at,
            'updated_at' => $booking->updated_at
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $booking = Booking::find($request->id);

        $request->validate([
            'status_booking' => 'required',
            'tgl_booking' => 'required'
        ]);

        if ($booking->update([
            'tgl_booking' => $request->tgl_booking,
            'status_booking' => $request->status_booking,
        ])) {
            return response()->json([
                'message' => 'booking berhasil diupdate',
                'data' => $booking
            ], 200);
        }
    }

    public function delete(Request $request)
    {
        if (Booking::find($request->id)->delete()) {
            return response()->json([
                'message' => 'booking berhasil didelete',
            ], 200);
        }
    }
}
