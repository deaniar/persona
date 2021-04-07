<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\phoneindo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user or !Hash::check($request->password, $user->password)) {
            return response()->json([
                'messege' => 'Password tidak sesuai'
            ], 401);
        }
        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json([
            'messege' => 'success',
            'user' => [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "telp" => $user['telp'],
                "umur" => $user['umur'],
                "ttl" => $user['ttl'],
                "alamat" => $user['alamat'],
                "province" => getProv($user['provinces_id'], 'name'),
                "city" => getCity($user['cities_id'], 'name'),
                "district" => getDistrict($user['districts_id'], 'name'),
                "gender" => $user['gender'],
                "image_profile" => $user['image_profile'],
                "email_verified_at" => $user['email_verified_at'],
                "password" => $user['password'],
                "status_akun" => $user['status_akun'],
                "created_at" => $user['created_at'],
                "updated_at" => $user['updated_at']
            ],
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        if ($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'telp' => ['required', new phoneindo, 'unique:users'],
            'password' => 'required',
        ])) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->telp = $request->telp;
            $user->level_role = 'pasien';
            $user->email_verified_at = now();
            $user->password = bcrypt($request->password);
            $user->remember_token = Str::random(10);
            $user->save();

            return response()->json([
                'message' => 'successfull register',
                'data' => $user
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil Logout'
        ], 200);
    }
}
