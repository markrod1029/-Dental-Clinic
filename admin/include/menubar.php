


<body   class="d-flex flex-column">


<div class="wrapper">
   
  <nav class="main-header navbar navbar-expand navbar-default navbar-light" style="background-color: #7ED956;">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars text-white text-white " style="  position:relative;  z-index: 1;"></i></a>
      </li>
    </ul>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>


                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="user_profile_name"></span>
                            <img class="img-profile rounded-circle"
                                src="<?php echo (!empty($user['photo']))? '../images/'.$user['photo']:'../images/profile.jpg'; ?>" width="30" height="30" id="user_profile_image">
                        </a>
                        <!-- Dropdown - User Information -->
                      
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logout.php" >
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                      
                       
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">