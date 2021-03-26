<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_dokter',
        'id_pasien',
        'tgl_booking',
        'status_booking',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */

    public function getDataBookingAll()
    {
        $booking = Booking::where(['status_booking' => 'terima'])->get();

        foreach ($booking as $b) {
            $pasien_data = User::where(['id' => $b['id_pasien']])->first();
            $dokter_data = User::where(['id' => $b['id_dokter']])->first();

            $data[] = [
                'id_booking' => $b['id'],
                'name_pasien' => $pasien_data['name'],
                'alamat_pasien' => $pasien_data['alamat'],
                'image_profile_pasien' => $pasien_data['image_profile'],
                'name_dokter' => $dokter_data['name'],
                'image_profile_dokter' => $dokter_data['image_profile'],
                'tgl_booking' => $b->tgl_booking,
                'status_booking' => $b['status_booking'],

            ];
        }
        return $data = (!empty($data)) ? $data : null;
    }


    public function getDataBooking($id_dokter, $status_booking)
    {
        return DB::table('bookings')
            ->join('users', 'bookings.id_pasien', '=', 'users.id')
            ->where(['id_dokter' => $id_dokter])
            ->whereIn('status_booking', $status_booking)
            ->select(
                'bookings.id',
                'bookings.id_dokter',
                'bookings.tgl_booking',
                'bookings.status_booking',
                'bookings.id_pasien',
                'users.name',
                'users.email',
                'users.telp',
                'users.umur',
                'users.ttl',
                'users.alamat',
                'users.gender',
                'users.name',
                'users.image_profile',
                'users.status_akun',
                'bookings.created_at',
                'bookings.updated_at',
            )->get()
            ->toArray();
    }
}
