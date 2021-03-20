    @extends('layouts.main-master')
    @section('content')
        <div class="content">
            <div class="row">
                <div class="col-sm-7 col-6">
                    <h4 class="page-title">Profile Dokter</h4>
                </div>

                <div class="col-sm-5 col-6 text-right m-b-30">
                    <a href="{{ route('doctors.edit', ['id' => $dokter['id']]) }}" class="btn btn-primary btn-rounded">
                        Edit Profile
                    </a>
                </div>
            </div>
            <div class="card-box profile-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#"><img class="avatar"
                                            src="{{ url('uploads/images/user') }}{{ !empty($dokter['image_profile']) ? '/' . $dokter['image_profile'] : '/user.jpg' }}"
                                            alt=""></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">{{ $dokter['name'] }}</h3>
                                            <div class="staff-id">Rating : {{ !empty($skor) ? $skor : '-' }}</div>
                                            <div class="staff-id">Jumlah Pasien :
                                                {{ !empty($total_pasien) ? $total_pasien : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <span class="title">Telphone:</span>
                                                <span class="text"><a href="#">{{ $dokter['telp'] }}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Email:</span>
                                                <span class="text"><a href="#">{{ $dokter['email'] }}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Usia:</span>
                                                <span class="text">{{ !empty($dokter['umur']) ? $dokter['umur'] : '-' }}
                                                    Tahun
                                                </span>
                                            </li>
                                            <li>
                                                <span class="title">Alamat:</span>
                                                <span
                                                    class="text">{{ !empty($dokter['alamat']) ? $dokter['alamat'] : '-' }}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="title">Gender:</span>
                                                <span
                                                    class="text">{{ !empty($dokter['gender']) ? $dokter['gender'] : '-' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Pasien</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="about-cont">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-sm-7 col-6">
                                            <h3 class="card-title">Jadwal Buka</h3>
                                        </div>
                                        <div class="col-sm-5 col-6 text-right m-b-30">
                                            <a href="" class="btn btn-primary btn-rounded">
                                                Edit Jadwal
                                            </a>
                                        </div>
                                    </div>
                                    <div class="experience-box">
                                        <ul class="experience-list">
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">Senin</a>
                                                        <div>08:00 - 17:00</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">Selasa</a>
                                                        <div>08:00 - 17:00</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">Rabu</a>
                                                        <div>08:00 - 17:00</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="experience-user">
                                                    <div class="before-circle"></div>
                                                </div>
                                                <div class="experience-content">
                                                    <div class="timeline-content">
                                                        <a href="#/" class="name">Kamis</a>
                                                        <div>08:00 - 17:00</div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="bottom-tab2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-box">
                                    <h3 class="card-title">Daftar Pasien</h3>
                                    <div class="experience-box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-border table-striped custom-table datatable mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Age</th>
                                                                <th>Address</th>
                                                                <th>Phone</th>
                                                                <th>Email</th>
                                                                <th class="text-right">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Jennifer
                                                                    Robinson</td>
                                                                <td>35</td>
                                                                <td>1545 Dorsey Ln NE, Leland, NC, 28451</td>
                                                                <td>(207) 808 8863</td>
                                                                <td>jenniferrobinson@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Terry Baker
                                                                </td>
                                                                <td>63</td>
                                                                <td>555 Front St #APT 2H, Hempstead, NY, 11550</td>
                                                                <td>(376) 150 6975</td>
                                                                <td>terrybaker@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Kyle Bowman
                                                                </td>
                                                                <td>7</td>
                                                                <td>5060 Fairways Cir #APT 207, Vero Beach, FL, 32967</td>
                                                                <td>(981) 756 6128</td>
                                                                <td>kylebowman@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Marie Howard
                                                                </td>
                                                                <td>22</td>
                                                                <td>3501 New Haven Ave #152, Columbia, MO, 65201</td>
                                                                <td>(634) 09 3833</td>
                                                                <td>mariehoward@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Joshua Guzman
                                                                </td>
                                                                <td>34</td>
                                                                <td>4712 Spring Creek Dr, Bonita Springs, FL, 34134</td>
                                                                <td>(407) 554 4146</td>
                                                                <td>joshuaguzman@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Julia Sims</td>
                                                                <td>27</td>
                                                                <td>517 Walker Dr, Houma, LA, 70364, United States</td>
                                                                <td>(680) 432 2662</td>
                                                                <td>juliasims@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Linda Carpenter
                                                                </td>
                                                                <td>24</td>
                                                                <td>2226 Victory Garden Ln, Tallahassee, FL, 32301</td>
                                                                <td>(218) 661 8316</td>
                                                                <td>lindacarpenter@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Melissa Burton
                                                                </td>
                                                                <td>35</td>
                                                                <td>3321 N 26th St, Milwaukee, WI, 53206</td>
                                                                <td>(192) 494 8073</td>
                                                                <td>melissaburton@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Patrick Knight
                                                                </td>
                                                                <td>21</td>
                                                                <td>Po Box 3336, Commerce, TX, 75429</td>
                                                                <td>(785) 580 4514</td>
                                                                <td>patrickknight@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Denise Stevens
                                                                </td>
                                                                <td>7</td>
                                                                <td>1603 Old York Rd, Abington, PA, 19001</td>
                                                                <td>(836) 257 1379</td>
                                                                <td>denisestevens@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Judy Clark</td>
                                                                <td>22</td>
                                                                <td>4093 Woodside Circle, Pensacola, FL, 32514</td>
                                                                <td>(359) 969 3594</td>
                                                                <td>judy.clark@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Dennis Salazar
                                                                </td>
                                                                <td>34</td>
                                                                <td>891 Juniper Drive, Saginaw, MI, 48603</td>
                                                                <td>(933) 137 6201</td>
                                                                <td>dennissalazar@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Charles Ortega
                                                                </td>
                                                                <td>32</td>
                                                                <td>3169 Birch Street, El Paso, TX, 79915</td>
                                                                <td>(380) 141 1885</td>
                                                                <td>charlesortega@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><img width="28" height="28" src="assets/img/user.jpg"
                                                                        class="rounded-circle m-r-5" alt=""> Sandra Mendez
                                                                </td>
                                                                <td>24</td>
                                                                <td>2535 Linden Avenue, Orlando, FL, 32789</td>
                                                                <td>(797) 506 1265</td>
                                                                <td>sandramendez@example.com</td>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle"
                                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                                class="fa fa-ellipsis-v"></i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                                href="edit-patient.html"><i
                                                                                    class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_patient"><i
                                                                                    class="fa fa-trash-o m-r-5"></i>
                                                                                Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="bottom-tab3">
                        Tab content 3
                    </div>
                </div>
            </div>
        </div>
    @endsection
