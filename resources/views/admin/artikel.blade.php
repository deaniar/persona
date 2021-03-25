 @extends('layouts.main-master')
 @section('content')

     <div class="content">
         <div class="row">
             <div class="col-sm-4 col-3">
                 <h4 class="page-title">Artikel</h4>
             </div>
             <div class="col-sm-8 col-9 text-right m-b-20">
                 <a href="{{ route('artikel.add') }}" class="btn btn-primary btn-rounded float-right"><i
                         class="fa fa-plus"></i> Add Artikel</a>
             </div>
         </div>
         @include('layouts.flash-alert')
         <div class="row">
             @foreach ($artikels as $artikel)
                 <div class="col-sm-6 col-md-6 col-lg-4">
                     <div class="blog grid-blog">
                         <div class="blog-image">
                             <a href="{{ route('artikel.show', ['id' => $artikel['id']]) }}">
                                 <img class="img-fluid" alt="{{ $artikel['judul'] }}"
                                     src="{{ url('uploads/images/artikel/' . $artikel['image']) }}">
                             </a>
                         </div>
                         <div class="blog-content">
                             <h3 class="blog-title"><a
                                     href="{{ route('artikel.show', ['id' => $artikel['id']]) }}">{{ $artikel['judul'] }}</a>
                             </h3>
                             <p>{{ \Illuminate\Support\Str::limit($artikel['isi'], 150, $end = '...') }}</p>
                             <a href="{{ route('artikel.show', ['id' => $artikel['id']]) }}" class="read-more"><i
                                     class="fa fa-long-arrow-right"></i> Read
                                 More</a>
                             <div class="blog-info clearfix">
                                 <div class="post-left">
                                     <ul>
                                         <li>
                                             <i class="fa fa-calendar"></i>
                                             <span>{{ date_format(date_create($artikel['created_at']), 'h:s | M d, Y') }}</span>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>
     </div>
 @endsection
