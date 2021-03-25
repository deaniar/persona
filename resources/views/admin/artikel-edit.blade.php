 @extends('layouts.main-master')
 @section('content')

     <div class="content">
         <div class="row">
             <div class="col-lg-8 offset-lg-2">
                 <a href="{{ route('artikel.show', ['id' => $artikel->id]) }}"><i class="fa fa-angle-left"></i> Back</a>
                 <hr>
                 <h4 class="page-title">Edit Artikel</h4>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-8 offset-lg-2">
                 @include('layouts.flash-alert')
                 <form method="POST" action="{{ route('artikel.update') }}" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="id_admin" value="{{ $user['id'] }}">
                     <input type="hidden" name="id" value="{{ $artikel->id }}">
                     <div class="form-group">
                         <label>Artikel Name</label>
                         <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                             name="title" value="{{ $artikel->judul }}">
                         @if ($errors->has('title'))
                             <span class="text-danger">{{ $errors->first('title') }}</span>
                         @endif
                     </div>
                     <div class="form-group">
                         <label>Artikel Images</label>
                         <div class="row">
                             <div class="col-3">
                                 <img src="{{ url('uploads/images/artikel/' . $artikel->image) }}"
                                     class="img-thumbnail w-100" alt="">
                             </div>
                             <div class="col-9">
                                 <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file"
                                     name="image">
                                 <small class="form-text text-muted">Max. file size: 1.5 MB. Allowed images:
                                     jpg,jpeg,png.</small>
                                 @if ($errors->has('image'))
                                     <span class="text-danger">{{ $errors->first('image') }}</span>
                                 @endif
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Artikel Category</label>
                                 <select class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}"
                                     name="kategori">
                                     <option value="">-- Select --</option>
                                     @foreach ($kategories as $kategori)
                                         <option value="{{ $kategori['id'] }}"
                                             {{ $artikel->id_kategori == $kategori['id'] ? 'selected' : '' }}>
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
                         <label>Artikel Description</label>
                         <textarea cols="30" rows="6" class="form-control {{ $errors->has('isi') ? 'is-invalid' : '' }}"
                             name="isi">{{ $artikel->isi }}</textarea>
                         @if ($errors->has('isi'))
                             <span class="text-danger">{{ $errors->first('isi') }}</span>
                         @endif
                     </div>
                     <div class="form-group">
                         <label class="display-block">Artikel Status</label>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="status" id="artikel_active" value="active"
                                 {{ $artikel->status == 'active' ? 'checked' : '' }}>
                             <label class="form-check-label" for="artikel_active">
                                 Active
                             </label>
                         </div>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="status" id="artikel_inactive"
                                 value="inactive" {{ $artikel->status == 'inactive' ? 'checked' : '' }}>
                             <label class="form-check-label" for="artikel_inactive">
                                 Inactive
                             </label>
                         </div>
                     </div>
                     <div class="m-t-20 text-center">
                         <button class="btn btn-primary submit-btn" type="submit">Publish artikel</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>

 @endsection
