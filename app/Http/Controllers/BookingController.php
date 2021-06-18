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

    //halaman booking 
    public function index()
    {
        $user = Auth::user();

        $data = [
            'title' => 'Appointments',
            'sidebar' => 'Appointments',
            'user' => $user,
            //ambil data booking dimana status = terima (method check di booking model)
            'appointments' =>  $this->BookingModel->getDataBookingAll()
        ];
        return view('admin.booking', $data);
    }

    //halaman booking dokter
    public function show()
    {
        $user = Auth::user();
        //kirim data ke getDataBoking dengan parameter id dokter dan status konofirmasi (method check di booking model)
        $belum_konfirmasi = $this->BookingModel->getDataBooking($user->id, ['konfirmasi']);
        //kirim data ke getDataBoking dengan parameter id dokter dan status terima (method check di booking model)
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

    //method post update status boking
    public function update(Request $request)
    {
        $booking = Booking::find($request->id);

        //jika request yang dikrim 1 maka ubah status boking jadi terima
        //jika request yang dikrim 1 maka ubah status boking jadi selesai
        //selain itu batalkan
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

        //check validasi status_booking
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
            //kirim data ke getDataBoking dengan parameter id dokter dan status terima dan dibatalkan (method check di booking model)
            'riwayat' => $this->BookingModel->getDataBooking($user->id, ['selesai', 'dibatalkan']),
        ];
        return view('dokter.booking-riwayat', $data);
    }
}
