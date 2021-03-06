 @extends('layouts.main-master')
 @section('content')
     <div class="content">
         <div class="row">
             <div class="col-lg-8 offset-lg-2">
                 <a href="{{ route('doctors') }}"><i class="fa fa-angle-left"></i> Back</a>
                 <hr>
                 <h4 class="page-title">Add Doctor</h4>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-8 offset-lg-2">
                 @include('layouts.flash-alert')
                 <form method="POST" action="{{ route('doctors.create') }}" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                         <div class="col-sm-12">
                             <div class="form-group">
                                 <label>Full Name <span class="text-danger">*</span></label>
                                 <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                     name="name" value="{{ old('name') }}">
                                 @if ($errors->has('name'))
                                     <span class="text-danger">{{ $errors->first('name') }}</span>
                                 @endif
                             </div>
                         </div>
                         <div class="col-sm-12">
                             <div class="form-group">
                                 <label>Email <span class="text-danger">*</span></label>
                                 <input class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                     name="email" value="{{ old('email') }}">
                                 @if ($errors->has('email'))
                                     <span class="text-danger">{{ $errors->first('email') }}</span>
                                 @endif
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>Password <span class="text-danger">*</span></label>
                                 <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                     type="password" name="password">
                                 @if ($errors->has('password'))
                                     <span class="text-danger">{{ $errors->first('password') }}</span>
                                 @endif
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>Confirm Password <span class="text-danger">*</span></label>
                                 <input class="form-control {{ $errors->has('password_match') ? 'is-invalid' : '' }}"
                                     type="password" name="password_match">
                                 @if ($errors->has('password_match'))
                                     <span class="text-danger">{{ $errors->first('password_match') }}</span>
                                 @endif
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>Date of Birth</label>
                                 <div class="cal-icon">
                                     <input type="text" class="form-control datetimepicker" name="ttl"
                                         value="{{ old('ttl') }}">
                                 </div>
                             </div>
                         </div>
                         <div class="col-sm-6 col-md-6">
                             <div class="form-group">
                                 <label>Gender</label>
                                 <select class="form-control select" name="gender">
                                     <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>
                                         Laki-laki
                                     </option>
                                     <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>
                                         Perempuan
                                     </option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-sm-6 col-md-6">
                             <div class="form-group">
                                 <label>provinsi</label>
                                 <select class="form-control select {{ $errors->has('province') ? 'is-invalid' : '' }}"
                                     name="province" id="province">
                                     <option value="">== Select Province ==</option>
                                     @foreach ($provinces as $id => $name)
                                         <option value="{{ $id }}"
                                             {{ old('provinsi') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                     @endforeach

                                 </select>
                                 @if ($errors->has('province'))
                                     <span class="text-danger">{{ $errors->first('province') }}</span>
                                 @endif
                             </div>
                         </div>
                         <div class="col-sm-6 col-md-6">
                             <div class="form-group">
                                 <label>Kabupaten/Kota</label>
                                 <select class="form-control select {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                     name="city" id="city">

                                     <option value="">== Select City ==</option>

                                 </select>
                                 @if ($errors->has('city'))
                                     <span class="text-danger">{{ $errors->first('city') }}</span>
                                 @endif
                             </div>
                         </div>
                         <div class="col-sm-6 col-md-6">
                             <div class="form-group">
                                 <label>Kecamatan</label>
                                 <select class="form-control select {{ $errors->has('district') ? 'is-invalid' : '' }}"
                                     name="district" id="district">

                                     <option value="">== Select District ==</option>

                                 </select>
                                 @if ($errors->has('district'))
                                     <span class="text-danger">{{ $errors->first('district') }}</span>
                                 @endif
                             </div>
                         </div>

                         <div class="col-sm-6 col-md-6">
                             <div class="row">
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <label>Address Lengkap</label>
                                         <input type="text"
                                             class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                                             name="alamat" value="{{ old('alamat') }}">
                                         @if ($errors->has('alamat'))
                                             <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                         @endif
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>Phone <span class="text-danger">*</span></label>
                                 <input class="form-control {{ $errors->has('telp') ? 'is-invalid' : '' }}" type="text"
                                     name="telp" value="{{ old('telp') }}">
                                 @if ($errors->has('telp'))
                                     <span class="text-danger">{{ $errors->first('telp') }}</span>
                                 @endif
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                                 <label>Avatar</label>
                                 <div class="profile-upload">
                                     <div class="upload-img">
                                         <img alt="" src="{{ asset('uploads/images/user/user.jpg') }}">
                                     </div>
                                     <div class="upload-input">
                                         <input type="file" class="form-control" name="image_profile" accept="image/*">
                                     </div>
                                     @if ($errors->has('image_profile'))
                                         <span class="text-danger">{{ $errors->first('image_profile') }}</span>
                                     @endif
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div class="form-group">
                         <label>Pengalaman</label>
                         <input onkeypress="validate(event)" class="form-control" type="text" name="pengalaman"
                             value="{{ old('pengalaman') }}">
                     </div>
                     <div class="form-group">
                         <label>Info</label>
                         <textarea class="form-control" rows="3" cols="30" name="info">{{ old('info') }}</textarea>
                     </div>
                     <div class="form-group">
                         <label class="display-block">Status</label>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="status" id="doctor_active" value="active"
                                 checked>
                             <label class="form-check-label" for="doctor_active">
                                 Active
                             </label>
                         </div>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="status" id="doctor_inactive"
                                 value="inactive">
                             <label class="form-check-label" for="doctor_inactive">
                                 Inactive
                             </label>
                         </div>
                     </div>
                     <div class="m-t-20 text-center">
                         <button class="btn btn-primary submit-btn" type="submit">Create Doctor</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 @endsection
