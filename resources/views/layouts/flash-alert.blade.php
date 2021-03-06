 @if (Session::has('success'))
     <div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>Success! </strong> {{ Session::get('success') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
     </div>
 @endif
 @if (Session::has('warning'))
     <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>Warning!</strong> {{ Session::get('warning') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
     </div>
 @endif

 @if (Session::has('danger'))
     <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>Error!</strong> {{ Session::get('danger') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
     </div>
 @endif
