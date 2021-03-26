<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->BookingModel = new Booking();
    }

    public function index()
    {
        $user = Auth::user();

        $data = [
            'title' => 'Appointments',
            'sidebar' => 'Appointments',
            'user' => $user,
            'appointments' =>  $this->BookingModel->getDataBookingAll()
        ];
        return view('admin.booking', $data);
    }

    public function show()
    {
        $user = Auth::user();
        $belum_konfirmasi = $this->BookingModel->getDataBooking($user->id, ['konfirmasi']);
        $sudah_konfirmasi = $this->BookingModel->getDataBooking($user->id, ['terima']);
        $data = [
            'title' => 'Appointments',
            'sidebar' => 'Appointments',
            'user' => $user,
            'belum_konfirmasi' => $belum_konfirmasi,
            'sudah_konfirmasi' =>  $sudah_konfirmasi
        ];
        return view('dokter.booking', $data);
    }

    public function update(Request $request)
    {
        $booking = Booking::find($request->id);

        switch ($request->status_booking) {
            case '1':
                $status_booking = 'terima';
                break;
            case '2':
                $status_booking = 'selesai';
                break;
            default:
                $status_booking = 'dibatalkan';
                break;
        }

        if ($booking->update([
            'status_booking' => $status_booking,
        ])) {
            return redirect()->route('booking');
        } else {
            $request->session()->flash('danger', 'Gagal update, hubungin admin');
            return redirect()->route('booking');
        }
    }

    public function riwayat()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Riwayat',
            'sidebar' => 'Riwayat',
            'user' => $user,
            'riwayat' => $this->BookingModel->getDataBooking($user->id, ['selesai', 'dibatalkan']),
        ];
        return view('dokter.booking-riwayat', $data);
    }
}
