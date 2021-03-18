 <div class="header">
     <div class="header-left">
         <a href="index-2.html" class="logo">
             <img src="{{ asset('assets/img/logo-persona.svg') }}" width="35" height="35" alt=""> <span>Persona</span>
         </a>
     </div>
     <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
     <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
     <ul class="nav user-menu float-right">
         <li class="nav-item dropdown d-none d-sm-block">
             <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i>
                 <span class="badge badge-pill bg-danger float-right">3</span></a>
             <div class="dropdown-menu notifications">
                 <div class="topnav-dropdown-header">
                     <span>Notifications</span>
                 </div>
                 <div class="drop-scroll">
                     <ul class="notification-list">
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">
                                         <img alt="John Doe" src="assets/img/user.jpg" class="img-fluid">
                                     </span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">John Doe</span> added
                                             new task <span class="noti-title">Patient appointment booking</span>
                                         </p>
                                         <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                         </p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">V</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Tarah Shropshire</span>
                                             changed the task name <span class="noti-title">Appointment booking
                                                 with payment gateway</span></p>
                                         <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                         </p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">L</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Misty Tison</span>
                                             added <span class="noti-title">Domenic Houston</span> and <span
                                                 class="noti-title">Claire Mapes</span> to project <span
                                                 class="noti-title">Doctor available module</span></p>
                                         <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                         </p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">G</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Rolland Webber</span>
                                             completed task <span class="noti-title">Patient and Doctor video
                                                 conferencing</span></p>
                                         <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                         </p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">V</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span>
                                             added new task <span class="noti-title">Private chat module</span>
                                         </p>
                                         <p class="noti-time"><span class="notification-time">2 days ago</span>
                                         </p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <div class="topnav-dropdown-footer">
                     <a href="activities.html">View all Notifications</a>
                 </div>
             </div>
         </li>

         <li class="nav-item dropdown has-arrow">
             <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                 <span class="user-img">
                     <img class="rounded-circle" src="{{ asset('') }}{{ $user['image_profile'] != null ? 'uploads/images/user/' . $user['image_profile'] : 'uploads/images/user/user.jpg' }}
                     " width="24" alt="{{ $user['name'] }}">
                     <span class="status online"></span>
                 </span>
                 <span>{{ $user['name'] }}</span>
             </a>
             <div class="dropdown-menu">
                 <a class="dropdown-item" href="{{ url('/profile') }}">My Profile</a>
                 <a class="dropdown-item" href="{{ url('/profile/edit') }}">Edit Profile</a>

                 <form action="{{ url('logout') }}" method="POST">
                     @csrf
                     <button class="dropdown-item" type="submit">Logout</button>
                 </form>

             </div>
         </li>
     </ul>
     <div class="dropdown mobile-user-menu float-right">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                 class="fa fa-ellipsis-v"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
             <a class="dropdown-item" href="{{ url('/profile') }}">My Profile</a>
             <a class="dropdown-item" href="{{ url('/profile/edit') }}">Edit Profile</a>

             <form action="{{ url('logout') }}" method="POST">
                 @csrf
                 <button class="dropdown-item" type="submit">Logout</button>
             </form>
         </div>
     </div>
 </div>
