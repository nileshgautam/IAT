 <!-- ============================================================== -->
 <!-- main wrapper -->
 <!-- ============================================================== -->
 <div class="dashboard-main-wrapper">
     <!-- ============================================================== -->
     <!-- navbar -->
     <!-- ============================================================== -->
     <div class="dashboard-header">
         <nav class="navbar navbar-expand-lg bg-primary fixed-top">
             <a class="navbar-brand text-white" href="<?php echo base_url('dashboard') ?>">Internal Audit Tool</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse " id="navbarSupportedContent">
                 <ul class="navbar-nav ml-auto navbar-right-top">
                     <li class="nav-item active">
                         <a class="nav-link" title="dashboard" href="<?php echo base_url('dashboard') ?>">
                             <i class="fa fa-fw fa-home text-white"></i><span class="text-white"> Dashboard</span></a>
                     </li>
                     <li class="nav-item dropdown connection">
                         <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th text-white"></i>
                             <span class="text-white">Menus</span>
                         </a>
                         <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                             <li class="connection-list">
                                 <span>Clients</span>
                                 <hr />
                                 <div class="row">
                                     <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                         <a class="connection-item" title=" Add new client" href="<?php echo base_url('new-client'); ?>">
                                             <i class="fa fa-fw fa-user"></i><span>New</span></a>
                                     </div>
                                     <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                         <a href="<?php echo base_url('all-clients'); ?>" class="connection-item">
                                             <i class="fa fa-fw fa-users"></i> <span>All Clients class</span></a>
                                     </div>
                                 </div>
                                 <hr />
                                 <span>Users</span>
                                 <!-- <hr> -->

                                 <div class="row">
                                     <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 ">

                                         <a href="<?php echo base_url('new-user'); ?>" class="connection-item"><i class="fa fa-fw fa-user"></i> <span>New</span></a>
                                     </div>
                                     <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                         <a href="<?php echo base_url('all-users'); ?>" class="connection-item"><i class="fa fa-fw fa-users"></i> <span>All users</span></a>
                                     </div>
                                 </div>
                                 <hr />
                                 <span>Work Orders</span>
                                 <!-- <hr> -->
                                 <div class="row">
                                     <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                         <a href="<?php echo base_url() . 'new-work-order' ?> " class="connection-item"><i class="fa fa-fw fa-tasks"></i> <span>New</span></a>
                                     </div>
                                     <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                         <a href="<?php echo base_url() . 'assign-work' ?>" class="connection-item"><i class="fa fa-fw fa-tasks"></i><span>Assign</span></a>
                                     </div>
                                     <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                         <a href="<?php echo base_url() . 'all-work-orders' ?>" title="All work order" class="connection-item"><i class="fa fa-fw fa-tasks"> </i><span>All work order</span></a>
                                     </div>
                                 </div>
                                 <hr>
                                 <span>Manage database</span>
                                 <div class="row">
                                     <div class="col-xl-4 col-lg-12 col-md-6 col-sm-12 col-12 ">
                                         <a title="Manage database" href="<?php echo base_url('MainWebsite/upload_excel'); ?>" class="connection-item"><i class="fa fa-fw fa-database"></i><span>Upload Master File</span></a>
                                     </div>
                                 </div>

                             </li>
                         </ul>
                     </li>

                     <li class="nav-item dropdown nav-user">
                         <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url(); ?>assets/images/icons/user.svg" alt="" class="user-avatar-md rounded-circle" width="25"></a>
                         <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                             <div class="nav-user-info">
                                 <h5 class="mb-0 text-white nav-user-name"><?php echo $_SESSION['userInfo']['username'] ?> </h5>
                                 <!-- <h5 class="mb-0 text-white nav-user-name"></h5> -->
                                 <span class="status"></span><span class="ml-2">Available</span>
                             </div>
                             <!-- <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a> -->
                             <a class="dropdown-item" href="<?php echo base_url('Login/logout') ?>"><i class="fas fa-power-off mr-2"></i>Logout</a>
                         </div>
                     </li>
                 </ul>
             </div>
         </nav>
     </div>
 </div>
     <!-- ============================================================== -->
     <!-- end navbar -->
     <!-- ============================================================== -->
     <!-- ============================================================== -->
     <!-- left sidebar -->
     <!-- ============================================================== -->
     <!-- <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="<?php echo base_url('dashboard') ?>"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Clients</a>
                                <div id="submenu-2" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url('new-client'); ?>">New</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url('all-clients'); ?>">All Clients</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i>Users</a>
                                <div id="submenu-3" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url('new-user'); ?>">New</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url('all-users'); ?>" allUsers>All Users</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                          
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Work Orders</a>
                                <div id="submenu-8" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url() . 'new-work-order' ?>">New</a>
                                            <a class="nav-link" href="<?php echo base_url() . 'assign-work' ?>">Assign</a>
                                            <a class="nav-link" href="<?php echo base_url() . 'all-work-orders' ?>">All Work Order</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-fw fa-wpforms"></i>Manage</a>
                                <div id="submenu-4" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url('MainWebsite/upload_excel'); ?>" >Upload Master File</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div> -->
     <!-- ============================================================== -->
     <!-- end left sidebar -->
     <!-- ============================================================== -->