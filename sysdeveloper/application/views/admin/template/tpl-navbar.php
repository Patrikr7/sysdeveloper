<div id="header" class="header navbar-default dash_header">
    <!-- begin navbar-header -->
    <div class="navbar-header">
        <a href="<?php echo base_url('admin'); ?>" class="navbar-brand"><span class="navbar-logo"></span> <?php echo TITLE_NAME; ?></a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- end navbar-header -->
    
    <!-- begin header-nav -->
    <ul class="navbar-nav navbar-right">
        <li class="dropdown navbar-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url('assets/uploads/users/'.$this->session->userOnline['user_img']) ?>" alt="" title=""/> 
                <span class="d-none d-md-inline"><?php echo $this->session->userOnline['user_name']; ?></span> <b class="caret"></b>
            </a>
            <div class="dropdown-menu dropdown-menu-right dash_header_profile">
                <a href="<?php echo base_url('admin/user/profile'); ?>" title="Perfil" class="dropdown-item">Editar Perfil</a>
                <div class="dropdown-divider"></div>
                <span class="dropdown-item button_action" rel="Deseja sair do Sistema?" title="Sair" callback="<?php echo base_url('admin'); ?>" callback_action="logout" id="<?php echo $user->user_id; ?>">
                    <b class="">
                        <i class="fa fa-sign-out"></i> Sair
                    </b>
                </span>
            </div>
        </li>
    </ul>
    <!-- end header navigation right -->
</div>