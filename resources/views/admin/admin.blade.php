 @extends('layouts.main-master')
 @section('content')
     <div class="content">

         <div class="row">
             <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">
                 <div class="card-box">

                     <div class="row">
                         <div class="col-sm-4 col-3">
                             <h4 class="page-title">Admin</h4>
                         </div>
                         <div class="col-sm-8 col-9 text-right m-b-20">
                             <a href="{{ route('admin.add') }}" class="btn btn btn-primary btn-rounded float-right"><i
                                     class="fa fa-plus"></i>
                                 Add Admin</a>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-12">
                             <div class="table-responsive">
                                 <table class="table table-border table-striped custom-table datatable mb-0">
                                     <thead>
                                         <tr>
                                             <th>Nama</th>
                                             <th>Telp</th>
                                             <th>Email</th>
                                             <th>Status</th>
                                             <th class="text-right">Action</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($admins as $admin)
                                             <tr>
                                                 <td><img width="28" height="28"
                                                         src="{{ url('uploads/images/user') }}{{ !empty($admin['image_profile']) ? '/' . $admin['image_profile'] : '/user.jpg' }}"
                                                         class="rounded-circle m-r-5" alt="{{ $admin['name'] }}">
                                                     {{ $admin['name'] }}</td>
                                                 <td>{{ $admin['telp'] }}</td>
                                                 <td>{{ $admin['email'] }}</td>
                                                 <td>
                                                     @if ($admin['status_akun'] == 'active')
                                                         <span class="custom-badge status-green">Active</span>
                                                     @else
                                                         <span class="custom-badge status-red">Inactive</span>
                                                     @endif
                                                 </td>
                                                 <td class="text-right">
                                                     <div class="dropdown dropdown-action">
                                                         <a href="#" class="action-icon dropdown-toggle"
                                                             data-toggle="dropdown" aria-expanded="false"><i
                                                                 class="fa fa-ellipsis-v"></i></a>
                                                         <div class="dropdown-menu dropdown-menu-right">
                                                             <a class="dropdown-item"
                                                                 href="{{ route('admin.edit', ['id' => $admin['id']]) }}"><i
                                                                     class="fa fa-pencil m-r-5"></i> Edit</a>
                                                             @if ($user['id'] !== $admin['id'])
                                                                 <a class="dropdown-item" href="#" data-toggle="modal"
                                                                     data-target="#delete_patient{{ $admin['id'] }}"><i
                                                                         class="fa fa-trash-o m-r-5"></i>
                                                                     Delete</a>
                                                             @endif
                                                         </div>
                                                     </div>
                                                 </td>
                                             </tr>
                                             <div id="delete_patient{{ $admin['id'] }}" class="modal fade delete-modal"
                                                 role="dialog">
                                                 <div class="modal-dialog modal-dialog-centered">
                                                     <div class="modal-content">
                                                         <div class="modal-body text-center">
                                                             <img src="{{ asset('assets/img/sent.png') }}" alt=""
                                                                 width="50" height="46">
                                                             <h3>Anda yakin ingin menghapus Akun Pasien?</h3>
                                                             <div class="m-t-20"> <a href="#" class="btn btn-white"
                                                                     data-dismiss="modal">Close</a>
                                                                 <form action="{{ route('admin.delete') }}"
                                                                     method="POST">
                                                                     @csrf
                                                                     <input type="hidden" name="id"
                                                                         value="{{ $admin['id'] }}">
                                                                     <button type="submit"
                                                                         class="btn btn-danger">Delete</button>
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
             </div>
         </div>

     </div>
 @endsection
