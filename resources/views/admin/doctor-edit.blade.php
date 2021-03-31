 @extends('layouts.main-master')
 @section('content')
     <div class="content">
         <div class="row">
             <div class="col-sm-12">
                 <a href="{{ route('doctors.id', ['id' => $dokter['id']]) }}"><i class="fa fa-angle-left"></i> Back</a>
                 <hr>
                 <h4 class="page-title">Edit Dokter</h4>
             </div>
         </div>
         @include('layouts.flash-alert')

         <form action="{{ route('doctors.update_account') }}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $dokter['id'] }}">
             <div class="card-box">
                 <h3 class="card-title">Informasi Akun</h3>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="form-group ">
                             <div class="form-focus">
                                 <label class="focus-label">Email</label>
                                 <input type="text"
                                     class="form-control floating {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                     value="{{ $dokter['email'] }}" name="email">
                             </div>
                             @if ($errors->has('email'))
                                 <span class="text-danger">{{ $errors->first('email') }}</span>
                             @endif
                         </div>
                         <div class="form-group p-2">
                             <label class="focus-label">Status</label>
                             <div class="form-check form-check-inline m-2">
                                 <input class="form-check-input" type="radio" name="status" id="doctor_active"
                                     value="active" {{ $dokter['status_akun'] == 'active' ? 'checked' : '' }}>
                                 <label class="form-check-label" for="doctor_active">
                                     Active
                                 </label>
                             </div>
                             <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="status" id="doctor_inactive"
                                     value="inactive" {{ $dokter['status_akun'] == 'inactive' ? 'checked' : '' }}>
                                 <label class="form-check-label" for="doctor_inactive">
                                     Inactive
                                 </label>
                             </div>
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
                             <a href="{{ url('doctors/' . $dokter['id'] . '/edit?change-password') }}" class="p-2">Change
                                 Password</a>
                         </div>
                     @endif

                 </div>
                 <div class="text-center m-t-20">
                     <button class="btn btn-primary submit-btn" type="submit">Save</button>
                 </div>
             </div>
         </form>
         <form method="POST" action="{{ route('doctors.update') }}" enctype="multipart/form-data">
             @csrf
             <input type="hidden" name="id" value="{{ $dokter['id'] }}">
             <div class="card-box">
                 <h3 class="card-title">Informasi Profile</h3>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="profile-img-wrap">
                             <img id="newavatar"
                                 src="{{ asset('uploads/images/user') }}{{ !empty($dokter['image_profile']) ? '/' . $dokter['image_profile'] : '/user.jpg' }}"
                                 alt="{{ $dokter['name'] }}" class="inline-block img-thumbnail">
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
                                                 value="{{ $dokter['name'] }}" name="name">
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
                                                 value="{{ date('d/m/Y', strtotime($dokter['ttl'])) }}" name="ttl">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Gendar</label>
                                         <select class="select form-control floating" name="gender">
                                             <option value="laki-laki"
                                                 {{ $dokter['gender'] == 'laki-laki' ? 'selected' : '' }}>
                                                 Laki-Laki</option>
                                             <option value="perempuan"
                                                 {{ $dokter['gender'] == 'perempuan' ? 'selected' : '' }}>
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
                                                     {{ $dokter['provinces_id'] == $id ? 'selected' : '' }}>
                                                     {{ $name }}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Kabupaten/Kota</label>
                                         <select class="select form-control floating" name="city" id="city">

                                             <option value="{{ $dokter['cities_id'] }}" selected>
                                                 {{ getCity($dokter['cities_id'], 'name') }}</option>
                                             <option value="">== Select City ==</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Kecamatan</label>
                                         <select class="select form-control floating" name="district" id="district">

                                             <option value="{{ $dokter['districts_id'] }}" selected>
                                                 {{ getDistrict($dokter['districts_id'], 'name') }}</option>
                                             <option value="">== Select District ==</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus">
                                         <label class="focus-label">Alamat</label>
                                         <input type="text" class="form-control floating" value="{{ $dokter['alamat'] }}"
                                             name="alamat">
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group ">
                                         <div class="form-focus">
                                             <label class="focus-label">No Telphone</label>
                                             <input type="text"
                                                 class="form-control floating {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                 value="{{ $dokter['telp'] }}" name="telp">
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
                                             value="{{ $dokter['pengalaman'] }}" name="pengalaman">
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group form-focus border h-100">
                                         <label class="focus-label">Info</label>
                                         <textarea class="form-control floating h-100" name="info"
                                             value="{{ $dokter['info'] }}">{{ $dokter['info'] }}</textarea>
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
