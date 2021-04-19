<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;

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

        $user = User::where(['level_role' => $level_role, 'id' => $id])->first();

        $sum_skor = Review::where(['id_dokter' => $id])->sum('skor');
        $count_review = Review::where(['id_dokter' => $id])->count();
        $skor = ($sum_skor && $count_review) ?  ($sum_skor / $count_review) : null;
        $jadwal = Jadwal::where(['id_dokter' => $id])->get();
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'telp' => $user->telp,
            'umur' => $user->umur,
            'alamat' => $user->alamat,
            'provinces' => Province::select('name')->where('id', $user->provinces_id)->first()->name,
            'cities' => City::select('name')->where('id', $user->cities_id)->first()->name,
            'districts' => District::select('name')->where('id', $user->districts_id)->first()->name,
            'gender' => $user->gender,
            'image_profile' =>  url('uploads/images/user') . '/' . $user->image_profile,
            'pengalaman' => $user->pengalaman,
            'info' => $user->info,
            'total_pasien' => Booking::where(['id_dokter' => $id, 'status_booking' => 'terima'])->count(),
            'skor' => $skor,
            'jadwal' => $jadwal,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];

        return $data;
    }
}
