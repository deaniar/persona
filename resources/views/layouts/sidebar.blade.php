  <div class="sidebar" id="sidebar">
      <div class="sidebar-inner slimscroll">
          <div id="sidebar-menu" class="sidebar-menu">
              <ul>
                  @if ($user['level_role'] == 'admin')
                      <li class="menu-title">Main Menu</li>
                      <li class="{{ $sidebar == 'Dashboard' ? 'active' : '' }}">
                          <a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                      </li>
                      <li class="{{ $sidebar == 'Doctors' ? 'active' : '' }}">
                          <a href="{{ route('doctors') }}"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                      </li>
                      <li class="{{ $sidebar == 'Patients' ? 'active' : '' }}">
                          <a href="{{ route('patients') }}"><i class="fa fa-wheelchair"></i>
                              <span>Patients</span></a>
                      </li>
                      <li class="{{ $sidebar == 'Appointments' ? 'active' : '' }}">
                          <a href="{{ route('appointments') }}"><i class="fa fa-calendar"></i>
                              <span>Appointments</span></a>
                      </li>
                      <li class="submenu ">
                          <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span
                                  class="menu-arrow"></span></a>
                          <ul style="display: none;">
                              <li>
                                  <a class="{{ $sidebar == 'Artikel' ? 'active' : '' }}"
                                      href="{{ route('artikel') }}">Articles</a>
                              </li>
                              <li>
                                  <a class="{{ $sidebar == 'Kategori' ? 'active' : '' }}"
                                      href="{{ route('kategori') }}">Kategori</a>
                              </li>
                          </ul>
                      </li>
                  @elseif ($user['level_role'] == 'dokter')
                      <li class="menu-title">Main Menu</li>
                      <li class="{{ $sidebar == 'Dashboard' ? 'active' : '' }}">
                          <a href="{{ url('/dokter') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                      </li>
                      <li class="{{ $sidebar == 'Schedule' ? 'active' : '' }}">
                          <a href="{{ route('jadwal', ['id' => $user['id']]) }}"><i class="fa fa-user-md"></i>
                              <span>Schedule</span></a>
                      </li>
                      <li class="{{ $sidebar == 'Appointments' ? 'active' : '' }}">
                          <a href="{{ url('/appointments') }}"><i class="fa fa-calendar"></i>
                              <span>Appointments</span></a>
                      </li>
                      <li class="{{ $sidebar == 'Riwayat' ? 'active' : '' }}">
                          <a href="{{ route('riwayat') }}"><i class="fa fa-history"></i>
                              <span>Riwayat</span></a>
                      </li>
                  @endif
              </ul>
          </div>
      </div>
  </div>
