 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4" style="position:fixed;" >
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar user panel (optional) -->
      <center>
      <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-style:none;">
        <div class="image">
          <img src="../images/buggy.jpg" class="img-circle elevation-2 d-flex " style="height:60px; width:60px; margin-left:60px;" >
        </div>
      </div>

      <div class="info" style="position:relative; top:-20px;" >
          <h5 href="#" class="d-block" >Christian Custodio </h5>
        </div>
        </center>
        <nav class="mt-2" style="font-size:18px;">
        <ul class="nav nav-pills nav-sidebar flex-column" style="color:white;" data-widget="treeview" role="menu">



                    <li class="nav-item">
            <a href="home.php" class="nav-link">
              <i class="nav-icon fa fa-tachometer"></i>
              <p>Dashboard</p>
            </a>
          </li>

          



          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
              Doctor
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="doctor.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Doctor List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add_doctor.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Doctor</p>
                </a>
              </li>
            </ul>
          </li>

     


 
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
              Patient
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">




              <li class="nav-item">
                <a href="patient.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Patient List
                  </p>
                </a>
              </li>
              
              
              <li class="nav-item">
                <a href="add_patient.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Patient</p>
                </a>
              </li>



              
              
              
              
            </ul>
          </li>
    

           <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
              Apointment
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="availavility.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Doctor Availability</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="schedule.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sheduled</p>
                </a>
              </li>
            </ul>
          </li>


          
           <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
              Report
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="apointment.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p> Apointment Report</p>
                </a>
              </li>
             
            </ul>
          </li>




        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <style>
.main-sidebar {
    padding-top: 0;
    background-color: #7ED956;
    height: 190px;
    color:#ffff;
}

[class*=sidebar-dark-] .sidebar a {
    color: #fff;
}

[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link {
  color: #fff;

}
    </style>