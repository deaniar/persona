<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Kategorie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(2)->create();

        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'telp' => '0812-3456-7890',
                'level_role' => 'admin',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Yunias Setiawati',
                'email' => 'yunias@mail.com',
                'telp' => '0812-3456-3023',
                'level_role' => 'dokter',
                'umur' => '24',
                'alamat' => 'Surabaya',
                'gender' => 'perempuan',
                'image_profile' => '1616728724_dokter.jpg',
                'pengalaman' => '2',
                'info' => 'dr. Yunias Setiawati, Sp.KJ adalah seorang Dokter Kejiwaan (Psikiatri). 
                Saat ini, dr. Yunias berpraktik di Siloam Hospitals Surabaya dan Rumah Sakit Mitra 
                Keluarga Kenjeran sebagai Dokter Psikiatri. Adapun layanan yang beliau berikan 
                diantaranya Konsultasi perihal kesehatan jiwa. dr. Yunias Setiawati, Sp.KJ menamatkan
                pendidikan Kedokteran Umum dan Spesialis Kesehatan Jiwa di Universitas Airlangga. 
                Beliau termasuk dalam anggota Ikatan Dokter Indonesia (IDI)',
                'email_verified_at' => now(),
                'password' => bcrypt('yunias123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'agus wijayanto',
                'email' => 'agus@mail.com',
                'telp' => '0812-3456-4444',
                'level_role' => 'pasien',
                'alamat' => 'Surabaya',
                'umur' => '22',
                'ttl' => '1999-03-10',
                'gender' => 'laki-laki',
                'image_profile' => '1616729898_user-06.jpg',
                'email_verified_at' => now(),
                'password' => bcrypt('agus123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'ferdian arjun',
                'email' => 'ferdian@mail.com',
                'telp' => '0812-3456-3333',
                'level_role' => 'pasien',
                'alamat' => 'Surabaya',
                'umur' => '20',
                'ttl' => '2000-06-15',
                'gender' => 'laki-laki',
                'email_verified_at' => now(),
                'password' => bcrypt('ferdian123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'anindya putri',
                'email' => 'anindya@mail.com',
                'telp' => '0812-3456-3231',
                'level_role' => 'pasien',
                'alamat' => 'Surabaya',
                'umur' => '21',
                'ttl' => '2000-01-08',
                'gender' => 'perempuan',
                'image_profile' => '1616729712_j.png',
                'email_verified_at' => now(),
                'password' => bcrypt('anindya123'),
                'remember_token' => Str::random(10),
            ],

        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $jadwals = [
            [
                'id_dokter' => 2,
                'hari' => 'senin',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
            ],
            [
                'id_dokter' => 2,
                'hari' => 'selasa',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
            ],
            [
                'id_dokter' => 2,
                'hari' => 'rabu',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
            ],
            [
                'id_dokter' => 2,
                'hari' => 'kamis',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '16:00:00',
            ],
            [
                'id_dokter' => 2,
                'hari' => 'jumat',
                'jam_buka' => '08:00:00',
                'jam_tutup' => '14:00:00',
            ]
        ];

        foreach ($jadwals as $jadwal) {
            Jadwal::create($jadwal);
        }

        $bookings = [
            [
                'id_dokter' => 2,
                'id_pasien' => 3,
                'tgl_booking' => now(),
                'status_booking' => 'konfirmasi'
            ],
            [
                'id_dokter' => 2,
                'id_pasien' => 4,
                'tgl_booking' => now()->addHour(3),
                'status_booking' => 'konfirmasi'
            ],
            [
                'id_dokter' => 2,
                'id_pasien' => 5,
                'tgl_booking' => now()->addDay(-2),
                'status_booking' => 'selesai'
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        $kategoris = [
            ['kategori' => 'kesehatan'],
            ['kategori' => 'trevel'],
            ['kategori' => 'tips & trick'],
        ];

        foreach ($kategoris as $kategori) {
            Kategorie::create($kategori);
        }

        $artikels = [
            [
                'id_admin' => 1,
                'judul' => 'Siapkan Kesehatan Mental Sejak Dini agar Kuat Hadapi Masalah di Masa Depan',
                'id_kategori' => 1,
                'image' => '1616730221_imageartikel.png',
                'isi' => 'Kesehatan mental yang baik diperlukan oleh setiap orang agar tidak mudah stres 
                dan mampu menghadapi dan menyelesaikan masalah kehidupan. Kesehatan mental yang prima perlu 
                dilatih dan dipersiapkan sejak dini.Menurut psikolog dari Universitas Gadjah Mada (UGM) Indria L.
                Gamayanti, setiap manusia memiliki masa-masa krisis dalam hidupnya. Namun, jika orang-orang tersebut 
                memiliki kesehatan mental yang baik maka mereka akan bisa bertahan.',
                'status' => 'active'
            ],
        ];

        foreach ($artikels as $artikel) {
            Artikel::create($artikel);
        }
    }
}
