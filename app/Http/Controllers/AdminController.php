<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $this->booking = new Booking();
        $dokter = User::where(['level_role' => 'dokter']);
        $pasien = User::where(['level_role' => 'pasien']);

        $data = [
            'title' => 'Dashboard',
            'sidebar' => 'Dashboard',
            'user' => $user,
            'dokter' => $dokter->get(),
            'appointments' =>  $this->booking->getDataBookingAll(),
            'count_dokter' => $dokter->count(),
            'count_pasien' => $pasien->count(),
            'count_terkonfirmasi' => Booking::where(['status_booking' => 'terima'])->count(),
            'count_pending' => Booking::where(['status_booking' => 'konfirmasi'])->count()
        ];
        return view('admin.dashboard', $data);
    }
}
