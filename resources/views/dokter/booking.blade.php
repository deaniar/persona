@extends('layouts.main-master')
@section('content')
    <div class="content">
        <div class="card-box">
            <h4 class="card-title">Appointments</h4>

            @include('layouts.flash-alert')

            @if (!empty($belum_konfirmasi))
                <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                    <li class="nav-item"><a class="nav-link active" href="#solid-justified-tab2" data-toggle="tab">Belum Di
                            Konfirmasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#solid-justified-tab1"
                            data-toggle="tab">Terkonfirmasi</a>
                    </li>
                </ul>
            @endif
            <div class="tab-content">
                <div class="tab-pane {{ !empty($belum_konfirmasi) ? 'show active' : '' }} " id="solid-justified-tab2">
                    <div class="row">
                        <div class="col-md-12">
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
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($belum_konfirmasi as $bk)
                                            <tr>
                                                <td>
                                                    <img width="28" height="28"
                                                        src="{{ url('uploads/images/user') }}{{ !empty($bk->image_profile) ? '/' . $bk->image_profile : '/user.jpg' }}"
                                                        class="rounded-circle m-r-5" alt="{{ $bk->name }}">
                                                    {{ $bk->name }}
                                                </td>
                                                <td>{{ date_format(date_create($bk->tgl_booking), 'd M y') }} /
                                                    {{ date_format(date_create($bk->tgl_booking), 'H:i') }}</td>
                                                <td>{{ $bk->alamat }}</td>
                                                <td>{{ !empty($bk->umur) ? $bk->umur : '-' }} Tahun</td>
                                                <td>{{ $bk->telp }}</td>
                                                <td>{{ $bk->email }}</td>
                                                <td class="text-center">
                                                    <div class="dropdown action-label">
                                                        <a class="custom-badge status-red dropdown-toggle" href="#"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            Kofirmasi
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <form action="{{ route('booking.update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" value="{{ $bk->id }}" name="id">
                                                                <button type="submit" name="status_booking"
                                                                    class="dropdown-item">Tolak</button>
                                                                <button type="submit" name="status_booking" value="1"
                                                                    class="dropdown-item">Terima</button>
                                                            </form>
                                                        </div>
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

                <div class="tab-pane  {{ empty($belum_konfirmasi) ? 'show active' : '' }}" id="solid-justified-tab1">
                    <div class="row">
                        <div class="col-md-12">
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

                                            <th class="text-right">Action</th>
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
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-ellipsis-v"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <form action="{{ route('booking.update') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" value="{{ $sk->id }}" name="id">
                                                                <button type="submit" name="status_booking" value="2"
                                                                    class="dropdown-item">Selesai</button>
                                                            </form>
                                                        </div>
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
@endsection
