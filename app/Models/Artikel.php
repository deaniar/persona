<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_admin',
        'judul',
        'id_kategori',
        'image',
        'isi',
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
    public function getDataArtikel($id_blog)
    {
        return DB::table('artikels')
            ->join('users', 'artikels.id_admin', '=', 'users.id')
            ->join('kategories', 'artikels.id_kategori', '=', 'kategories.id')
            ->where(['artikels.id' => $id_blog])
            ->select(
                'artikels.id',
                'users.name',
                'users.image_profile',
                'artikels.judul',
                'kategories.kategori',
                'artikels.image',
                'artikels.isi',
                'artikels.status',
                'artikels.created_at',
                'artikels.updated_at'
            )->get()
            ->toArray();
    }
    public function getDataArtikelbyAPI($id_blog)
    {
        $data = Artikel::where(['id' => $id_blog])->first();
        $kategori = Kategorie::where(['id' => $data->id_kategori])->first();
        $admin = User::where(['id' => $data->id_admin])->first();

        return  [
            'id' => $data->id,
            'id_admin' => $data->id_admin,
            'uploader' => $admin->name,
            'judul' => $data->judul,
            'kategori' => $kategori->kategori,
            'image' => url('uploads/images/artikel') . '/' . $data->image,
            'isi' => $data->isi,
            'status' => $data->status,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
        ];
    }
}
