 @extends('layouts.main-master')
 @section('content')

     <div class="content">

         @include('layouts.flash-alert')
         <div class="row">
             <div class="col-sm-4 col-3">
                 <h4 class="page-title">Doctors</h4>
             </div>
             <div class="col-sm-8 col-9 text-right m-b-20">
                 <a href="{{ url('doctors/add') }}" class="btn btn-primary btn-rounded float-right"><i
                         class="fa fa-plus"></i> Add Doctor</a>
             </div>
         </div>

         <div class="row doctor-grid">
             @foreach ($doctors as $doctor)
                 <div class="col-md-4 col-sm-4  col-lg-3">
                     <div class="profile-widget">
                         <div class="doctor-img">
                             <a class="avatar" href="{{ route('doctors.id', ['id' => $doctor['id']]) }}"><img
                                     alt="{{ $doctor['name'] }}"
                                     src="{{ url('uploads/images/user') }}{{ !empty($doctor['image_profile']) ? '/' . $doctor['image_profile'] : '/user.jpg' }}"></a>
                         </div>
                         <div class="dropdown profile-action">
                             <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                                     class="fa fa-ellipsis-v"></i></a>
                             <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="{{ route('doctors.edit', ['id' => $doctor['id']]) }}"><i
                                         class="fa fa-pencil m-r-5"></i>
                                     Edit</a>
                                 <a class="dropdown-item" href="#" data-toggle="modal"
                                     data-target="#delete_doctor{{ $doctor['id'] }}"><i class="fa fa-trash-o m-r-5"></i>
                                     Delete</a>

                             </div>
                         </div>
                         <h4 class="doctor-name text-ellipsis"><a
                                 href="{{ route('doctors.id', ['id' => $doctor['id']]) }}">{{ $doctor['name'] }}</a>
                         </h4>
                         <div class="doc-prof">{{ $doctor['level_role'] }}</div>
                         <div class="user-country">
                             <i class="fa fa-map-marker"></i> {{ $doctor['alamat'] }}
                         </div>
                     </div>
                 </div>
                 <div id="delete_doctor{{ $doctor['id'] }}" class="modal fade delete-modal" role="dialog">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-body text-center">
                                 <img src="{{ asset('assets/img/sent.png') }}" alt="" width="50" height="46">
                                 <h3>Anda yakin ingin menghapus Dokter?</h3>
                                 <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                     <form action="{{ route('doctors.delete') }}" method="POST">
                                         @csrf
                                         <input type="hidden" name="id" value="{{ $doctor['id'] }}">
                                         <button type="submit" class="btn btn-danger">Delete</button>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             @endforeach

         </div>
     </div>

 @endsection
