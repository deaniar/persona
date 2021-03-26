 @extends('layouts.main-master')
 @section('content')
     <div class="content">
         <div class="row">
             <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                 <div class="dash-widget">
                     <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                     <div class="dash-widget-info text-right">
                         <h3>{{ $count_dokter }}</h3>
                         <span class="widget-title1">Doctors <i class="fa fa-check" aria-hidden="true"></i></span>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                 <div class="dash-widget">
                     <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                     <div class="dash-widget-info text-right">
                         <h3>{{ $count_pasien }}</h3>
                         <span class="widget-title2">Patients <i class="fa fa-check" aria-hidden="true"></i></span>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                 <div class="dash-widget">
                     <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                     <div class="dash-widget-info text-right">
                         <h3>{{ $count_terkonfirmasi }}</h3>
                         <span class="widget-title3">Attend <i class="fa fa-check" aria-hidden="true"></i></span>
                     </div>
                 </div>
             </div>
             <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                 <div class="dash-widget">
                     <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                     <div class="dash-widget-info text-right">
                         <h3>{{ $count_pending }}</h3>
                         <span class="widget-title4">Pending <i class="fa fa-check" aria-hidden="true"></i></span>
                     </div>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                 <div class="card">
                     <div class="card-header">
                         <h4 class="card-title d-inline-block">Appointments</h4> <a href="{{ route('appointments') }}"
                             class="btn btn-primary float-right">View all</a>
                     </div>
                     <div class="card-body p-0">
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
             <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                 <div class="card member-panel">
                     <div class="card-header bg-white">
                         <h4 class="card-title mb-0">Doctors</h4>
                     </div>
                     <div class="card-body">
                         <ul class="contact-list">
                             @foreach ($dokter as $d)
                                 <li>
                                     <div class="contact-cont">
                                         <div class="float-left user-img m-r-10">
                                             <a href="{{ route('doctors.id', ['id' => $d['id']]) }}"
                                                 title="{{ $d['name'] }}">
                                                 <img src="{{ url('uploads/images/user') }}{{ !empty($d['image_profile']) ? '/' . $d['image_profile'] : '/user.jpg' }}"
                                                     class="w-40 rounded-circle" alt="{{ $d['name'] }}">
                                                 <span class="status online"></span></a>
                                         </div>
                                         <div class="contact-info">
                                             <span
                                                 class="contact-name text-ellipsis text-capitalize">{{ $d['name'] }}</span>
                                             <span class="contact-date">{{ $d['alamat'] }}</span>
                                         </div>
                                     </div>
                                 </li>
                             @endforeach
                         </ul>
                     </div>
                     <div class="card-footer text-center bg-white">
                         <a href="{{ route('doctors') }}" class="text-muted">View all Doctors</a>
                     </div>
                 </div>
             </div>
         </div>

     </div>
 @endsection
