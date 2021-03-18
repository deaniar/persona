  <div class="sidebar" id="sidebar">
      <div class="sidebar-inner slimscroll">
          <div id="sidebar-menu" class="sidebar-menu">
              <ul>
                  @if ($user['level_role'] == 'admin')
                      <li class="menu-title">Main Menu</li>
                      <li class="active">
                          <a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                      </li>
                      <li>
                          <a href="{{ url('/doktors') }}"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                      </li>
                      <li>
                          <a href="{{ url('/patients') }}"><i class="fa fa-wheelchair"></i>
                              <span>Patients</span></a>
                      </li>
                      <li class="submenu">
                          <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span
                                  class="menu-arrow"></span></a>
                          <ul style="display: none;">
                              <li><a href="blog.html">Blog</a></li>
                              <li><a href="blog-details.html">Blog View</a></li>
                              <li><a href="add-blog.html">Add Blog</a></li>
                              <li><a href="edit-blog.html">Edit Blog</a></li>
                          </ul>
                      </li>
                      <li>
                          <a href="{{ url('/activities') }}"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
                      </li>
                      <li class="submenu">
                          <a href="#"><i class="fa fa-flag-o"></i> <span> Reports </span> <span
                                  class="menu-arrow"></span></a>
                          <ul style="display: none;">
                              <li><a href="expense-reports.html"> Expense Report </a></li>
                              <li><a href="invoice-reports.html"> Invoice Report </a></li>
                          </ul>
                      </li>
                      <li>
                          <a href="settings.html"><i class="fa fa-cog"></i> <span>Settings</span></a>
                      </li>
                  @elseif ($user['level_role'] == 'dokter')
                      <li class="menu-title">Main Menu</li>
                      <li class="active">
                          <a href="{{ url('/dokter') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                      </li>
                      <li>
                          <a href="{{ url('/schedule') }}"><i class="fa fa-user-md"></i> <span>Schedule</span></a>
                      </li>
                      <li>
                          <a href="{{ url('/appointments') }}"><i class="fa fa-calendar"></i>
                              <span>Appointments</span></a>
                      </li>
                      <li>
                          <a href="{{ url('/mypatients') }}"><i class="fa fa-wheelchair"></i> <span>My
                                  Patients</span></a>
                      </li>

                      <li>
                          <a href="{{ url('/activities') }}"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
                      </li>

                  @endif
              </ul>
          </div>
      </div>
  </div>
