<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'telp',
        'umur',
        'ttl',
        'provinces_id',
        'cities_id',
        'districts_id',
        'alamat',
        'gender',
        'image_profile',
        'pengalaman',
        'info',
        'status_akun',
        'updated_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'level_role'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUser($id, $level_role)
    {

        $dokter = User::where(['level_role' => $level_role, 'id' => $id])->first();

        $sum_skor = Review::where(['id_dokter' => $id])->sum('skor');
        $count_review = Review::where(['id_dokter' => $id])->count();
        $skor = ($sum_skor && $count_review) ?  ($sum_skor / $count_review) : null;

        $jadwal = Jadwal::where(['id_dokter' => $id])->get();
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
            'jadwal' => $jadwal,
            'created_at' => $dokter->created_at,
            'updated_at' => $dokter->updated_at
        ];

        return $data;
    }
}
