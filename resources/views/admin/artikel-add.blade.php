 @extends('layouts.main-master')
 @section('content')

     <div class="content">
         <div class="row">
             <div class="col-lg-8 offset-lg-2">
                 <a href="{{ route('artikel') }}"><i class="fa fa-angle-left"></i> Back</a>
                 <hr>
                 <h4 class="page-title">Add Artikel</h4>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-8 offset-lg-2">
                 @include('layouts.flash-alert')
                 <form method="POST" action="{{ route('artikel.create') }}" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="id_admin" value="{{ $user['id'] }}">
                     <div class="form-group">
                         <label>Article Name</label>
                         <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                             name="title" value="{{ old('title') }}">
                         @if ($errors->has('title'))
                             <span class="text-danger">{{ $errors->first('title') }}</span>
                         @endif
                     </div>
                     <div class="form-group">
                         <label>Article Images</label>
                         <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file"
                             name="image">
                         @if ($errors->has('image'))
                             <span class="text-danger">{{ $errors->first('image') }}</span>
                         @endif
                         <small class="form-text text-muted">Max. file size: 1.5 MB. Allowed images: jpg,jpeg,png.</small>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Article Category</label>
                                 <select class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}"
                                     name="kategori">
                                     <option value="">-- Select --</option>
                                     @foreach ($kategories as $kategori)
                                         <option value="{{ $kategori['id'] }}"
                                             {{ old('kategori') == $kategori['id'] ? 'selected' : '' }}>
                                             {{ $kategori['kategori'] }}
                                         </option>
                                     @endforeach
                                 </select>
                                 @if ($errors->has('kategori'))
                                     <span class="text-danger">{{ $errors->first('kategori') }}</span>
                                 @endif
                             </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label>Article Description</label>
                         <textarea cols="30" rows="6" class="form-control {{ $errors->has('isi') ? 'is-invalid' : '' }}"
                             name="isi">{{ old('isi') }}</textarea>
                         @if ($errors->has('isi'))
                             <span class="text-danger">{{ $errors->first('isi') }}</span>
                         @endif
                     </div>
                     <div class="form-group">
                         <label class="display-block">Article Status</label>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="status" id="Article_active" value="active"
                                 checked>
                             <label class="form-check-label" for="Article_active">
                                 Active
                             </label>
                         </div>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="status" id="Article_inactive"
                                 value="inactive">
                             <label class="form-check-label" for="Article_inactive">
                                 Inactive
                             </label>
                         </div>
                     </div>
                     <div class="m-t-20 text-center">
                         <button class="btn btn-primary submit-btn" type="submit">Publish Article</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>

 @endsection
