    @extends('layouts.main-master')
    @section('content')
        <div class="content">
            <div class="row">
                <div class="col-sm-7 col-6">
                    <h4 class="page-title">Profile Dokter</h4>
                </div>

                <div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="{{ route('doctors.edit', ['id' => $dokter['id']]) }}" class="btn btn-primary btn-rounded">
                        Edit Profile
                    </a>
                </div>
            </div>
            <div class="card-box profile-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href=""><img class="avatar"
                                            src="{{ url('uploads/images/user') }}{{ !empty($dokter['image_profile']) ? '/' . $dokter['image_profile'] : '/user.jpg' }}"
                                            alt=""></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">{{ $dokter['name'] }}</h3>
                                            <div class="staff-id">Rating : {{ !empty($skor) ? $skor : '-' }}</div>
                                            <div class="staff-id">Jumlah Pasien :
                                                {{ !empty($total_pasien) ? $total_pasien : '-' }}</div>
                                            <p class="text-justify small pr-3 pt-2">{{ $dokter['info'] }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <span class="title">Telphone:</span>
                                                <span class="text"><a href="#">{{ $dokter['telp'] }}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Email:</span>
                                                <span class="text"><a href="#">{{ $dokter['email'] }}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Usia:</span>
                                                <span class="text">{{ !empty($dokter['umur']) ? $dokter['umur'] : '-' }}
                                                    Tahun
                                                </span>
                                            </li>
                                            <li>
                                                <span class="title">Alamat:</span>
                                                <span
                                                    class="text">{{ !empty($dokter['alamat']) ? $dokter['alamat'] : '-' }}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="title">Gender:</span>
                                                <span
                                                    class="text">{{ !empty($dokter['gender']) ? $dokter['gender'] : '-' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pasien" data-toggle="tab">Pasien</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="profile">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-sm-7 col-6">
                                            <h3 class="card-title">Jadwal Buka</h3>
                                        </div>
                                        <div class="col-sm-5 col-6 text-right m-b-30">
                                            <a href="{{ route('jadwal', ['id' => $dokter['id']]) }}"
                                                class="btn btn-primary btn-rounded">
                                                Edit Jadwal
                                            </a>
                                        </div>
                                    </div>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            @foreach ($jadwals as $jadwal)
                                                <li>
                                                    <div class="experience-user">
                                                        <div class="before-circle"></div>
                                                    </div>
                                                    <div class="experience-content">
                                                        <div class="timeline-content">
                                                            <a class="name text-capitalize">{{ $jadwal['hari'] }}</a>
                                                            <div>
                                                                {{ date_format(date_create($jadwal['jam_buka']), 'H:i') }}
                                                                -
                                                                {{ date_format(date_create($jadwal['jam_tutup']), 'H:i') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="pasien">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Tanggal / Jam</th>
                                                    <th>Alamat</th>
                                                    <th>Umur</th>
                                                    <th>Telp</th>
                                                    <th>Email</th>
                                                    <th class="text-right">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sudah_konfirmasi as $sk)
                                                    <tr>
                                                        <td>
                                                            <img width="28" height="28"
                                                                src="{{ url('uploads/images/user') }}{{ !empty($sk->image_profile) ? '/' . $sk->image_profile : '/user.jpg' }}"
                                                                class="rounded-circle m-r-5" alt="{{ $sk->name }}">
                                                            {{ $sk->name }}
                                                        </td>
                                                        <td>{{ date_format(date_create($sk->tgl_booking), 'd M y') }} /
                                                            {{ date_format(date_create($sk->tgl_booking), 'H:i') }}</td>
                                                        <td>{{ $sk->alamat }}</td>
                                                        <td>{{ !empty($sk->umur) ? $sk->umur : '-' }} Tahun</td>
                                                        <td>{{ $sk->telp }}</td>
                                                        <td>{{ $sk->email }}</td>
                                                        <td class="text-center">
                                                            <div class="dropdown action-label">
                                                                @if ($sk->status_booking == 'terima')
                                                                    <span
                                                                        class="text-capitalize custom-badge status-blue">{{ $sk->status_booking }}</span>
                                                                @elseif ($sk->status_booking == 'selesai')
                                                                    <span
                                                                        class="text-capitalize custom-badge status-green">{{ $sk->status_booking }}</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
