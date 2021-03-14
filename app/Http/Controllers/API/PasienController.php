<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Booking;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasienController extends Controller
{
    public function index()
    {
        $data = User::where('level_role', 'pasien')->get();
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $pasien = User::where(['level_role' => 'pasien', 'id' => $id])->first();

        $data = [
            'id' => $pasien->id,
            'name' => $pasien->name,
            'email' => $pasien->email,
            'telp' => $pasien->telp,
            'umur' => $pasien->umur,
            'alamat' => $pasien->alamat,
            'gender' => $pasien->gender,
            'image_profile' => url('uploads/images/user') . '/' . $pasien->image_profile,
            'email_verified_at' => $pasien->email_verified_at,
            'status_akun' => $pasien->status_akun,
            'created_at' => $pasien->created_at,
            'updated_at' => $pasien->updated_at
        ];
        return response()->json($data, 200);
    }

    public function edit($id)
    {
        $pasien = User::where(['level_role' => 'pasien', 'id' => $id])->first();
        $data = [
            'id' => $pasien->id,
            'name' => $pasien->name,
            'email' => $pasien->email,
            'telp' => $pasien->telp,
            'umur' => $pasien->umur,
            'alamat' => $pasien->alamat,
            'gender' => $pasien->gender,
            'image_profile' => url('uploads/images/user') . '/' . $pasien->image_profile,
            'email_verified_at' => $pasien->email_verified_at,
            'status_akun' => $pasien->status_akun,
            'created_at' => $pasien->created_at,
            'updated_at' => $pasien->updated_at
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request)
    {

        $pasien = User::find($request->id);

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
                    if ($pasien->image_profile !== null) {
                        unlink(public_path('uploads/images/user/') . $pasien->image_profile);
                    }
                }
            } else {
                $fileName = $pasien->image_profile;
            }
            $pasien->update([
                'name' => $request->name,
                'email' =>  $request->email,
                'telp' => $request->telp,
                'umur' => $request->umur,
                'alamat' => $request->alamat,
                'gender' => $request->gender,
                'image_profile' => $fileName,
                'level_role' => $request->level_role,
                'password' =>  bcrypt($request->password),
            ]);

            return response()->json([
                'message' => 'pasien berhasil di update',
                'data' => $pasien
            ], 200);
        }
    }

    public function delete(Request $request)
    {
        $pasien = User::find($request->id);
        unlink(public_path('uploads/images/user/') . $pasien->image_profile);
        if ($pasien->delete()) {
            return response()->json([
                'message' => 'successfull delete',
            ], 200);
        }
    }

    public function booking($id)
    {
        $booking = Booking::where(['id_pasien' => $id])->get();


        foreach ($booking as $b) {
            $data[] = [
                'detail_booking' =>  $b,
                'detail_dokter' => User::where(['id' => $b->id_dokter])->first()
            ];
        }
        return response()->json($data, 400);
    }
}
