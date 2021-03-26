 @extends('layouts.main-master')
 @section('content')
     <div class="content">
         <div class="row">
             <div class="col-sm-12">
                 <a href="{{ route('admin.users') }}"><i class="fa fa-angle-left"></i> Back</a>
                 <hr>
                 <h4 class="page-title">Edit admin</h4>
             </div>
         </div>
         @include('layouts.flash-alert')

         <form action="{{ route('admin.update_account') }}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $admin['id'] }}">
             <div class="card-box">
                 <h3 class="card-title">Informasi Akun</h3>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="form-group ">
                             <div class="form-focus">
                                 <label class="focus-label">Email</label>
                                 <input type="text"
                                     class="form-control floating {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                     value="{{ $admin['email'] }}" name="email">
                             </div>
                             @if ($errors->has('email'))
                                 <span class="text-danger">{{ $errors->first('email') }}</span>
                             @endif
                         </div>
                         <div class="form-group p-2">
                             <label class="focus-label">Status</label>
                             <div class="form-check form-check-inline m-2">
                                 <input class="form-check-input" type="radio" name="status" id="doctor_active"
                                     value="active" {{ $admin['status_akun'] == 'active' ? 'checked' : '' }}>
                                 <label class="form-check-label" for="doctor_active">
                                     Active
                                 </label>
                             </div>
                             <div class="form-check form-check-inline">
                                 <input class="form-check-input" type="radio" name="status" id="doctor_inactive"
                                     value="inactive" {{ $admin['status_akun'] == 'inactive' ? 'checked' : '' }}>
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
                             <a href="{{ route('admin.edit', ['id' => $admin['id'], 'change-password']) }}"
                                 class="p-2">Change
                                 Password</a>
                         </div>
                     @endif

                 </div>
                 <div class="text-center m-t-20">
                     <button class="btn btn-primary submit-btn" type="submit">Save</button>
                 </div>
             </div>
         </form>
         <form method="POST" action="{{ route('admin.update') }}" enctype="multipart/form-data">
             @csrf
             <input type="hidden" name="id" value="{{ $admin['id'] }}">
             <div class="card-box">
                 <h3 class="card-title">Informasi Profile</h3>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="profile-img-wrap">
                             <img id="newavatar"
                                 src="{{ asset('uploads/images/user') }}{{ !empty($admin['image_profile']) ? '/' . $admin['image_profile'] : '/user.jpg' }}"
                                 alt="{{ $admin['name'] }}" class="inline-block img-thumbnail">
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
                                                 value="{{ $admin['name'] }}" name="name">
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
                                                 value="{{ date('d/m/Y', strtotime($admin['ttl'])) }}" name="ttl">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group form-focus select-focus">
                                         <label class="focus-label">Gendar</label>
                                         <select class="select form-control floating" name="gender">
                                             <option value="laki-laki"
                                                 {{ $admin['gender'] == 'laki-laki' ? 'selected' : '' }}>
                                                 Laki-Laki</option>
                                             <option value="perempuan"
                                                 {{ $admin['gender'] == 'perempuan' ? 'selected' : '' }}>
                                                 Perempuan</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group form-focus">
                                         <label class="focus-label">Alamat</label>
                                         <input type="text" class="form-control floating" value="{{ $admin['alamat'] }}"
                                             name="alamat">
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group ">
                                         <div class="form-focus">
                                             <label class="focus-label">No Telphone</label>
                                             <input type="text"
                                                 class="form-control floating {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                 value="{{ $admin['telp'] }}" name="telp">
                                         </div>
                                         @if ($errors->has('telp'))
                                             <span class="text-danger">{{ $errors->first('telp') }}</span>
                                         @endif
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
