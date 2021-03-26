<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->level_role == 'admin') {
                return redirect('admin');
            } else {
                return redirect('dokter');
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {

        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credensil = $request->only('email', 'password');
        if (Auth::attempt($credensil)) {
            $user = Auth::user();

            session([
                'user_id' => $user->id
            ]);

            if ($user->level_role = 'admin') {
                return redirect()->intended('admin');
            } else if ($user->level_role = 'dokter') {
                return redirect()->intended('dokter');
            } else {
                return redirect()->intended('/');
            }
        }
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('login');
    }


    public function forgotPassword(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        //Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => now()
        ]); //Get the token just created above
        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();


        if ($this->sendResetEmail($request->email, $tokenData->token)) {

            $request->session()->flash('success', 'Cek Email anda untuk mendapatkan link reset password');
            return redirect()->back();
        } else {
            $request->session()->flash('danger', 'A Network Error occurred. Please try again.');
        }
    }

    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($user->email);
        try {
            $details = [
                'token' => $token,
                'email' => $email
            ];
            Mail::to($email)->send(new \App\Mail\MailResetPassword($details));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function resetPassword($t, $e)
    {
        $check_token = DB::table('password_resets')->where(['token' => $t])->first();
        if ($check_token) {
            $data = [
                'token' => $t,
                'email' => $e
            ];
            return view('auth.reset-password', $data);
        } else {
            echo 'invalid';
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->update([
            'password' =>  bcrypt($request->password),
        ])) {
            DB::table('password_resets')->where(['token' => $request->token])->delete();

            $request->session()->flash('success', 'Password berhasil di ubah');
            return redirect()->route('login');
        }
    }
}
