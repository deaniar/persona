 @extends('layouts.main-master')
 @section('content')
     <div class="content">
         <div class="row">
             <div class="col-sm-4 col-3">
                 <h4 class="page-title">Patients</h4>
             </div>
             <div class="col-sm-8 col-9 text-right m-b-20">
                 <a href="{{ route('patients.add') }}" class="btn btn btn-primary btn-rounded float-right"><i
                         class="fa fa-plus"></i>
                     Add Patient</a>
             </div>
         </div>
         <div class="row">
             <div class="col-md-12">
                 <div class="table-responsive">
                     <table class="table table-border table-striped custom-table datatable mb-0">
                         <thead>
                             <tr>
                                 <th>Nama</th>
                                 <th>Umur</th>
                                 <th>Alamat</th>
                                 <th>Telp</th>
                                 <th>Email</th>
                                 <th>Status</th>
                                 <th class="text-right">Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($pasiens as $pasien)
                                 <tr>
                                     <td><img width="28" height="28"
                                             src="{{ url('uploads/images/user') }}{{ !empty($pasien['image_profile']) ? '/' . $pasien['image_profile'] : '/user.jpg' }}"
                                             class="rounded-circle m-r-5" alt="{{ $pasien['name'] }}">
                                         {{ $pasien['name'] }}</td>
                                     <td>{{ !empty($pasien['umur']) ? $pasien['umur'] : '-' }} Tahun</td>
                                     <td>{{ !empty(getProv($pasien['provinces_id'], 'name')) ? getProv($pasien['provinces_id'], 'name') : '-' }}
                                     </td>
                                     <td>{{ $pasien['telp'] }}</td>
                                     <td>{{ $pasien['email'] }}</td>
                                     <td>
                                         @if ($pasien['status_akun'] == 'active')
                                             <span class="custom-badge status-green">Active</span>
                                         @else
                                             <span class="custom-badge status-red">Inactive</span>
                                         @endif
                                     </td>
                                     <td class="text-right">
                                         <div class="dropdown dropdown-action">
                                             <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                 aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">
                                                 <a class="dropdown-item"
                                                     href="{{ route('patients.edit', ['id' => $pasien['id']]) }}"><i
                                                         class="fa fa-pencil m-r-5"></i> Edit</a>
                                                 <a class="dropdown-item" href="#" data-toggle="modal"
                                                     data-target="#delete_patient{{ $pasien['id'] }}"><i
                                                         class="fa fa-trash-o m-r-5"></i>
                                                     Delete</a>
                                             </div>
                                         </div>
                                     </td>
                                 </tr>
                                 <div id="delete_patient{{ $pasien['id'] }}" class="modal fade delete-modal"
                                     role="dialog">
                                     <div class="modal-dialog modal-dialog-centered">
                                         <div class="modal-content">
                                             <div class="modal-body text-center">
                                                 <img src="{{ asset('assets/img/sent.png') }}" alt="" width="50"
                                                     height="46">
                                                 <h3>Anda yakin ingin menghapus Akun Pasien?</h3>
                                                 <div class="m-t-20"> <a href="#" class="btn btn-white"
                                                         data-dismiss="modal">Close</a>
                                                     <form action="{{ route('patients.delete') }}" method="POST">
                                                         @csrf
                                                         <input type="hidden" name="id" value="{{ $pasien['id'] }}">
                                                         <button type="submit" class="btn btn-danger">Delete</button>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 @endsection
