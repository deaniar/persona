 @extends('layouts.main-master')
 @section('content')
     <div class="content">
         <div class="row">
             <div class="col-sm-12">
                 <h4 class="page-title">Edit Profile</h4>
             </div>
         </div>
         @include('layouts.flash-alert')

         <form action="{{ url('/user/update-account') }}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $user['id'] }}">
             <div class="card-box">
                 <h3 class="card-title">Informasi Akun</h3>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="form-group ">
                             <div class="form-focus">
                                 <label class="focus-label">Email</label>
                                 <input type="text"
                                     class="form-control floating {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                     value="{{ $user['email'] }}" name="email">
                             </div>
                             @if ($errors->has('email'))
                                 <span class="text-danger">{{ $errors->first('email') }}</span>
                             @endif
                         </div>
                     </div>
                     @if (isset($_GET['change-password']))
                         <div class="col-md-6">
                             <div class="form-group ">
                                 <div class="form-focus">
                                     <label class="focus-label">Old Password</label>
                                     <input type="password"
                                         class="form-control floating {{ $errors->has('oldpass') ? 'is-invalid' : '' }} "
                                         name="oldpass">
                                 </div>
                                 @if ($errors->has('oldpass'))
                                     <span class="text-danger">{{ $errors->first('oldpass') }}</span>
                                 @endif
                             </div>

                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <div class="form-focus">
                                     <label class="focus-label">New Password</label>
                                     <input type="password"
                                         class="form-control floating {{ $errors->has('newpass') ? 'is-invalid' : '' }}"
                                         name="newpass">
                                 </div>
                                 @if ($errors->has('newpass'))
                                     <span class="text-danger">{{ $errors->first('newpass') }}</span>
                                 @endif
                             </div>
                         </div>
                     @else
                         <div class="col-md-6 pt-md-3">
                             <a href="{{ url('profile/edit?change-password') }}">Change Password</a>
                         </div>
                     @endif

                 </div>
                 <div class="text-center m-t-20">
                     <button class="btn btn-primary submit-btn" type="submit">Save</button>
                 </div>
             </div>
         </form>
         <form method="POST" action="{{ url('/user/update') }}" enctype="multipart/form-data">
             @csrf
             <input type="hidden" name="id" value="{{ $user['id'] }}">
             <div class="card-box">
                 <h3 class="card-title">Informasi Profile</h3>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="profile-img-wrap">
                             <img id="newavatar"
                                 src="{{ asset('') }}{{ $user['image_profile'] != null ? 'uploads/images/user/' . $user['image_profile'] : 'uploads/images/user/user.jpg' }}"
                                 alt="{{ $user['name'] }}" class="inline-block img-thumbnail">
                             <div class="fileupload btn">
                                 <span class="btn-text">edit</span>
                                 <input id="input-file" class="upload" type="file" name="image_profile" accept="image/*"
                                     onchange="changeImage()">
                             </div>
                         </div>
                         <div class="profile-basic">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group ">
                                         <div class="form-focus">
                                             <label class="focus-label">Full Name</label>
                                             <input type="text"
                                                 class="form-control floating {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                 value="{{ $user['name'] }}" name="name">
                                         </div>
                                         @if ($errors->has('name'))
                                             <span class="text-danger">{{ $errors->first('name') }}</span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus">
                                         <label class="focus-label">Tangal Lahir</label>
                                         <div class="cal-icon">
                                             <input class="form-control floating datetimepicker" type="text"
                                                 value="{{ date('d/m/Y', strtotime($user['ttl'])) }}" name="ttl">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Gendar</label>
                                         <select class="select form-control floating" name="gender">
                                             <option value="laki-laki"
                                                 {{ $user['gender'] == 'laki-laki' ? 'selected' : '' }}>
                                                 Laki-Laki</option>
                                             <option value="perempuan"
                                                 {{ $user['gender'] == 'perempuan' ? 'selected' : '' }}>
                                                 Perempuan</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Provinsi</label>
                                         <select class="select form-control floating" name="province" id="province">
                                             <option value="">== Select Province ==</option>
                                             @foreach ($provinces as $id => $name)
                                                 <option value="{{ $id }}"
                                                     {{ $user['provinces_id'] == $id ? 'selected' : '' }}>
                                                     {{ $name }}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Kabupaten/Kota</label>
                                         <select class="select form-control floating" name="city" id="city">

                                             <option value="{{ $user['cities_id'] }}" selected>
                                                 {{ getCity($user['cities_id'], 'name') }}</option>
                                             <option value="">== Select City ==</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Kecamatan</label>
                                         <select class="select form-control floating" name="district" id="district">

                                             <option value="{{ $user['districts_id'] }}" selected>
                                                 {{ getDistrict($user['districts_id'], 'name') }}</option>
                                             <option value="">== Select District ==</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus">
                                         <label class="focus-label">Alamat</label>
                                         <input type="text" class="form-control floating" value="{{ $user['alamat'] }}"
                                             name="alamat">
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group ">
                                         <div class="form-focus">
                                             <label class="focus-label">No Telphone</label>
                                             <input type="text"
                                                 class="form-control floating {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                 value="{{ $user['telp'] }}" name="telp">
                                         </div>
                                         @if ($errors->has('telp'))
                                             <span class="text-danger">{{ $errors->first('telp') }}</span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group form-focus">
                                         <label class="focus-label">Pengalaman</label>
                                         <input onkeypress="validate(event)" type="text" class="form-control floating"
                                             value="{{ $user['pengalaman'] }}" name="pengalaman">
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group form-focus border h-100">
                                         <label class="focus-label">Info</label>
                                         <textarea class="form-control floating h-100" name="info"
                                             value="{{ $user['info'] }}">{{ $user['info'] }}</textarea>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="text-center m-t-20">
                     <button class="btn btn-primary submit-btn" type="submit">Save</button>
                 </div>
             </div>
         </form>
     </div>
 @endsection
