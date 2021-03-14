<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Booking;
use App\Models\Review;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class DokterController extends Controller
{
    public function index()
    {
        $data = User::where('level_role', 'dokter')->get();
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $dokter = User::where(['level_role' => 'dokter', 'id' => $id])->first();

        $sum_skor = Review::where(['id_dokter' => $id])->sum('skor');
        $count_review = Review::where(['id_dokter' => $id])->count();
        $skor = ($sum_skor && $count_review) ?  ($sum_skor / $count_review) : null;

        $data = [
            'id' => $dokter->id,
            'name' => $dokter->name,
            'email' => $dokter->email,
            'telp' => $dokter->telp,
            'umur' => $dokter->umur,
            'alamat' => $dokter->alamat,
            'gender' => $dokter->gender,
            'image_profile' =>  url('uploads/images/user') . '/' . $dokter->image_profile,
            'pengalaman' => $dokter->pengalaman,
            'info' => $dokter->info,
            'total_pasien' => Booking::where(['id_dokter' => $id, 'status_booking' => 'terima'])->count(),
            'skor' => $skor,
            'created_at' => $dokter->created_at,
            'updated_at' => $dokter->updated_at
        ];
        return response()->json($data, 200);
    }

    public function edit($id)
    {
        $dokter = User::where(['level_role' => 'dokter', 'id' => $id])->first();

        $sum_skor = Review::where(['id_dokter' => $id])->sum('skor');
        $count_review = Review::where(['id_dokter' => $id])->count();
        $skor = ($sum_skor && $count_review) ?  ($sum_skor / $count_review) : null;

        $data = [
            'id' => $dokter->id,
            'name' => $dokter->name,
            'email' => $dokter->email,
            'telp' => $dokter->telp,
            'umur' => $dokter->umur,
            'alamat' => $dokter->alamat,
            'gender' => $dokter->gender,
            'image_profile' =>  url('uploads/images/user') . '/' . $dokter->image_profile,
            'pengalaman' => $dokter->pengalaman,
            'info' => $dokter->info,
            'total_pasien' => Booking::where(['id_dokter' => $id, 'status_booking' => 'terima'])->count(),
            'skor' => $skor,
            'created_at' => $dokter->created_at,
            'updated_at' => $dokter->updated_at
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $dokter = User::find($request->id);

        if ($request->validate([
            'name' => 'required',
            'email' => 'required',
            'telp' => ['required', new phoneindo],
            'image_profile' => 'image:jpeg,png,jpg|max:2048',
            'password' => 'required',

        ])) {

            if ($request->image_profile) {
                $fileName = time() . '_' . $request->image_profile->getClientOriginalName();
                if ($request->image_profile->move(public_path('uploads/images/user'), $fileName)) {
                    if ($dokter->image_profile !== null) {
                        unlink(public_path('uploads/images/user/') . $dokter->image_profile);
                    }
                }
            } else {
                $fileName = $dokter->image_profile;
            }
            $dokter->update([
                'name' => $request->name,
                'email' =>  $request->email,
                'telp' => $request->telp,
                'umur' => $request->umur,
                'alamat' => $request->alamat,
                'gender' => $request->gender,
                'image_profile' => $fileName,
                'pengalaman' => $request->pengalaman,
                'info' => $request->info,
                'level_role' => $request->level_role,
                'password' =>  bcrypt($request->password),
            ]);

            return response()->json([
                'message' => 'dokter berhasil di update',
                'data' => $dokter
            ], 200);
        }
    }

    public function delete(Request $request)
    {
        $dokter = User::find($request->id);
        unlink(public_path('uploads/images/user/') . $dokter->image_profile);
        if ($dokter->delete()) {
            return response()->json([
                'message' => 'successfull delete',
            ], 200);
        }
    }

    public function booking($id)
    {
        $booking = Booking::where(['id_dokter' => $id])->get();

        foreach ($booking as $b) {
            $data[] = [
                'detail_booking' =>  $b,
                'detail_pasien' => User::where(['id' => $b->id_pasien])->first()
            ];
        }

        return response()->json($data, 200);
    }

    public function review(Request $request, $id = null)
    {
        if (!$id) {
            if ($request->validate([
                'id_dokter' => 'required',
                'id_pasien' => 'required',
                'skor' => 'required|numeric',
            ])) {
                $review = new Review;
                $review->id_dokter = $request->id_dokter;
                $review->id_pasien = $request->id_pasien;
                $review->skor = $request->skor;
                $review->save();

                return response()->json([
                    'message' => 'successfull review',
                    'data' => $review
                ], 200);
            }
        } else {
            $data = Review::where('id_dokter', $id)->get();
            return response()->json($data, 200);
        }
    }
}
