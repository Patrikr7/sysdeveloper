<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <a href="<?php echo base_url('admin'); ?>" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="<?php echo base_url('assets/uploads/users/' . $this->session->userOnline['user_img']) ?>" alt="" title="" />
                    </div>
                    <div class="info">
                        <?php echo $this->session->userOnline['user_name']; ?>
                        <small>:: <?php echo $this->session->userOnline['user_title_level']; ?> ::</small>
                    </div>
                </a>
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav p-t-10">
            <li class="has-sub <?php echo (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "dash") ? "active" : "") ?>">
                <a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">
                    <i class="fa fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-book"></i>
                    <span>Menu</span>
                </a>
                <ul class="sub-menu">
                    <li class="">
                        <a href="<?php echo base_url('admin'); ?>" title="Ver Menu">Ver Menu</a>
                    </li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-book"></i>
                    <span>Menu</span>
                </a>
                <ul class="sub-menu">
                    <li class="">
                        <a href="<?php echo base_url('admin'); ?>" title="Ver Menu">Ver Menu</a>
                    </li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-book"></i>
                    <span>Menu</span>
                </a>
                <ul class="sub-menu">
                    <li class="">
                        <a href="<?php echo base_url('admin'); ?>" title="Ver Menu">Ver Menu</a>
                    </li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-book"></i>
                    <span>Menu</span>
                </a>
                <ul class="sub-menu">
                    <li class="">
                        <a href="<?php echo base_url('admin'); ?>" title="Ver Menu">Ver Menu</a>
                    </li>
                </ul>
            </li>

            <li class="has-sub <?= (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "UserActive") ? "active" : "") ?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fa fa-user"></i>
                    <span>Usuários</span>
                </a>
                <ul class="sub-menu">
                    <li class="<?= (!empty($menuActive["subPage"]) && ($menuActive["subPage"] == "UserHome") ? "active" : "") ?>">
                        <a href="<?php echo base_url('admin/users'); ?>" title="Ver Usuários">Ver Usuários</a>
                    </li>

                    <li class="<?= (!empty($menuActive["subPage"]) && ($menuActive["subPage"] == "UserCreate") ? "active" : "") ?>">
                        <a href="<?php echo base_url('admin/users/create'); ?>" title="Novo Usuário">Novo Usuário</a>
                    </li>
                </ul>
            </li>

            <li class="has-sub <?= (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "PermissionsActive") ? "active" : "") ?>">
                <a href="<?php echo base_url('admin/permissions'); ?>" title="Permissões">
                    <i class="fas fa-key"></i>
                    <span>Permissão</span>
                </a>
            </li>

            <li class="has-sub">
                <a href="<?php echo base_url(); ?>" target="_blank" title="Ver Site">
                    <i class="fa fa-star"></i>
                    <span>Ver Site</span>
                </a>
            </li>
            <!-- begin sidebar minify button -->
            <li>
                <a href="<?php echo base_url('admin'); ?>" class="sidebar-minify-btn" data-click="sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>