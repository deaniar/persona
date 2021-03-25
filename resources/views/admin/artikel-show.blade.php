   @extends('layouts.main-master')
   @section('content')
       <div class="content">
           <div class="row">
               <div class="col-sm-12">
                   <a href="{{ route('artikel') }}"><i class="fa fa-angle-left"></i> Back</a>
                   <hr>
                   <div class="row">
                       <div class="col-sm-4 col-3">
                           <h4 class="page-title">Artikel View</h4>
                       </div>
                       <div class="col-sm-8 col-9 text-right m-b-20">
                           <a href="#" class="btn btn-danger btn-rounded float-right ml-2" data-toggle="modal"
                               data-target="#delete_artikel{{ $artikel->id }}"> Delete
                           </a>
                           <a href="{{ route('artikel.edit', ['id' => $artikel->id]) }}"
                               class="btn btn-primary btn-rounded float-right"> Edit
                           </a>
                       </div>
                   </div>
               </div>
           </div>
           @include('layouts.flash-alert')

           <div class="row">
               <div class="col-md-12">
                   <div class="blog-view">
                       <article class="blog blog-single-post">
                           <h3 class="blog-title">{{ $artikel->judul }}</h3>
                           <div class="blog-info clearfix">
                               <div class="post-left">
                                   <ul>
                                       <li>
                                           <i class="fa fa-calendar"></i>
                                           <span>{{ date_format(date_create($artikel->created_at), 'h:s | M d, Y') }}</span>
                                       </li>
                                       <li>
                                           <i class="fa fa-user-o"></i> <span class="text-capitalize">By
                                               {{ $artikel->name }}</span>
                                       </li>
                                   </ul>
                               </div>
                           </div>
                           <div class="blog-image">
                               <img class="img-fluid" alt="{{ $artikel->judul }}"
                                   src="{{ url('uploads/images/artikel/' . $artikel->image) }}">
                           </div>
                           <div class="blog-content">
                               {{ $artikel->isi }}
                           </div>
                       </article>
                   </div>
               </div>
           </div>
       </div>
       <div id="delete_artikel{{ $artikel->id }}" class="modal fade delete-modal" role="dialog">
           <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                   <div class="modal-body text-center">
                       <img src="{{ asset('assets/img/sent.png') }}" alt="" width="50" height="46">
                       <h3>Anda yakin ingin menghapus Artikel ini?</h3>
                       <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                           <form action="{{ route('artikel.delete') }}" method="POST">
                               @csrf
                               <input type="hidden" name="id" value="{{ $artikel->id }}">
                               <button type="submit" class="btn btn-danger">Delete</button>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   @endsection
