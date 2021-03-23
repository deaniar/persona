@extends('layouts.main-master')
@section('content')
    <div class="content">
        <div class="card-box">
            <h4 class="card-title">Riwayat</h4>

            @include('layouts.flash-alert')

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

                                    <th class="text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat as $bk)
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
                                                <a class="custom-badge  {{ $bk->status_booking == 'dibatalkan' ? ' status-red' : 'status-green' }}  "
                                                    href="#">
                                                    {{ $bk->status_booking }}
                                                </a>
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

@endsection
