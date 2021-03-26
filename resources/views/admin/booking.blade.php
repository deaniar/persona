@extends('layouts.main-master')
@section('content')
    <div class="content">
        <div class="card-box">
            <h4 class="card-title">Appointments</h4>

            @include('layouts.flash-alert')

            <div class="tab-content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="d-none">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Timing</th>
                                        <th class="text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($appointments)
                                        @foreach ($appointments as $appo)
                                            <tr>
                                                <td style="min-width: 200px;">

                                                    <img width="28" height="28"
                                                        src="{{ url('uploads/images/user') }}{{ !empty($appo['image_profile_pasien']) ? '/' . $appo['image_profile_pasien'] : '/user.jpg' }}"
                                                        class="rounded-circle m-r-5" alt="{{ $appo['name_pasien'] }}">
                                                    <h2 class="text-capitalize">{{ $appo['name_pasien'] }}
                                                        <span>{{ $appo['alamat_pasien'] }}</span>
                                                    </h2>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Appointment With</h5>
                                                    <p>{{ $appo['name_dokter'] }}</p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Timing</h5>
                                                    <p>{{ date_format(date_create($appo['tgl_booking']), 'D | H:i') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Status</h5>
                                                    <span
                                                        class="custom-badge status-green text-capitalize">{{ $appo['status_booking'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @else
                                        <tr>
                                            <center class="m-5">
                                                <span>
                                                    Belum ada Janji Temu
                                                </span>
                                            </center>

                                        </tr>

                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
