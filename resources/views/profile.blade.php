 @extends('layouts.main-master')
 @section('content')
     <div class="content">
         <div class="row">
             <div class="col-sm-7 col-6">
                 <h4 class="page-title">My Profile</h4>
             </div>

             <div class="col-sm-5 col-6 text-right m-b-30">
                 <a href="{{ url('/profile/edit') }}" class="btn btn-primary btn-rounded"> Edit
                     Profile</a>
             </div>
         </div>

         @include('layouts.flash-alert')

         <div class="card-box profile-header">
             <div class="row">
                 <div class="col-md-12">
                     <div class="profile-view">
                         <div class="profile-img-wrap">
                             <div class="profile-img">
                                 <a href="#"><img class="avatar"
                                         src="{{ asset('') }}{{ $user['image_profile'] != null ? 'uploads/images/user/' . $user['image_profile'] : 'uploads/images/user/user.jpg' }}"
                                         alt="{{ $user['name'] }}"></a>
                             </div>
                         </div>
                         <div class="profile-basic">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="profile-info-left">
                                         <h3 class="user-name m-t-0 mb-0">{{ $user['name'] }}</h3>
                                         <div class="staff-id mb-1">Type : {{ $user['level_role'] }}</div>
                                         <p class="text-justify small pr-3">{{ $user['info'] }}</p>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <ul class="personal-info">
                                         <li>
                                             <span class="title">Telphone:</span>
                                             <span class="text"><a href="#">{{ $user['telp'] }}</a></span>
                                         </li>
                                         <li>
                                             <span class="title">Email:</span>
                                             <span class="text"><a href="#">{{ $user['email'] }}</a></span>
                                         </li>
                                         <li>
                                             <span class="title">Usia:</span>
                                             <span class="text">{{ !empty($user['umur']) ? $user['umur'] : '-' }} Tahun
                                             </span>
                                         </li>
                                         <li>
                                             <span class="title">Alamat:</span>
                                             <span class="text text-capitalize">
                                                 {{ getAddress($user['id'], 'name') }},
                                                 {{ !empty($user['alamat']) ? $user['alamat'] : '-' }}
                                             </span>
                                         </li>
                                         <li>
                                             <span class="title">Gender:</span>
                                             <span
                                                 class="text">{{ !empty($user['gender']) ? $user['gender'] : '-' }}</span>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
