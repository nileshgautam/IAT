<div class="dashboard-main-wrapper">
     <!-- ============================================================== -->
     <!-- navbar -->
     <!-- ============================================================== -->
     <div class="dashboard-header">
         <nav class="navbar navbar-expand-lg bg-primary fixed-top">
             <a class="navbar-brand text-white" href="<?php echo base_url('manager') ?>">Internal Audit Tool</a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse " id="navbarSupportedContent">
                 <ul class="navbar-nav ml-auto navbar-right-top">
                     <li class="nav-item active">
                         <a class="nav-link" title="dashboard" href="<?php echo base_url('manager') ?>">
                             <i class="fa fa-fw fa-home text-white"></i><span class="text-white"> Dashboard</span></a>
                     </li>
                     <!-- <li class="nav-item dropdown connection">
                         <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th text-white"></i>
                             <span class="text-white">Menus</span>
                         </a>
                         <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                             <li class="connection-list">
                                 <span>work orders</span>
                                 <hr />
                                 <div class="row">
                                     <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                         <a class="connection-item" title="Assigned task" href="<?php echo base_url('Auditapp/assignedTask')?>">
                                             <i class="fa fa-fw fa-user"></i><span>Assigned task</span></a>
                                     </div>
                                     <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                         <a title="all work orders" href="<?php echo base_url().'manager/work-orders'?>" class="connection-item">
                                             <i class="fa fa-fw fa-users"></i> <span>Work orders</span></a>
                                     </div>
                                 </div>

                             </li>
                         </ul>
                     </li> -->

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