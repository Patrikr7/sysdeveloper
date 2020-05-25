<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <a href="<?php echo base_url('admin'); ?>" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="<?php echo base_url('assets/uploads/users/' . $this->session->userOnline['user_img']); ?>" alt="" title="" />
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
            <li class="has-sub <?php echo (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "dash") ? "active" : ""); ?>">
                <a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">
                    <i class="fa fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>

<<<<<<< HEAD
            <?php if ($this->user->hasPermission('view_page') && intval(getenv('SIS_PAGE')) === 1) : ?>
=======
            <?php if ($this->user->hasPermission('view_page')) : ?>
>>>>>>> 41a7919cd8349e392a820f468268b365283ca407
                <li class="has-sub <?php echo (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "PageActive") ? "active" : ""); ?>">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fas fa-file-alt"></i>
                        <span>Páginas</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php echo (!empty($menuActive["subPage"]) && ($menuActive["subPage"] == "PageHome") ? "active" : ""); ?>">
                            <a href="<?php echo base_url('admin/page'); ?>" title="Ver Páginas">Ver Páginas</a>
                        </li>
                        <li class="<?php echo (!empty($menuActive["subPage"]) && ($menuActive["subPage"] == "PageCreate") ? "active" : ""); ?>">
                            <a href="<?php echo base_url('admin/page/new'); ?>" title="Nova Página">Nova Página</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($this->user->hasPermission('view_user')) : ?>
                <li class="has-sub <?php echo (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "UserActive") ? "active" : ""); ?>">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-user"></i>
                        <span>Usuários</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php echo (!empty($menuActive["subPage"]) && ($menuActive["subPage"] == "UserHome") ? "active" : ""); ?>">
                            <a href="<?php echo base_url('admin/users'); ?>" title="Ver Usuários">Ver Usuários</a>
                        </li>

                        <li class="<?php echo (!empty($menuActive["subPage"]) && ($menuActive["subPage"] == "UserCreate") ? "active" : ""); ?>">
                            <a href="<?php echo base_url('admin/users/new'); ?>" title="Novo Usuário">Novo Usuário</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($this->user->hasPermission('view_permission')) : ?>
                <li class="has-sub <?php echo (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "PermissionsActive") ? "active" : ""); ?>">
                    <a href="<?php echo base_url('admin/permissions'); ?>" title="Permissões">
                        <i class="fas fa-key"></i>
                        <span>Permissão</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($this->user->hasPermission('view_configuration')) : ?>
                <li class="has-sub <?php echo (!empty($menuActive["menuPage"]) && ($menuActive["menuPage"] == "config") ? "active" : ""); ?>">
                    <a href="<?php echo base_url('admin/configuration'); ?>" title="Configuração Geral">
                        <i class="fa fa-cogs"></i>
                        <span>Configuração</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="has-sub">
                <a href="<?php echo base_url(); ?>" target="_blank" title="Ver Site">
                    <i class="fa fa-star"></i>
                    <span>Ver Site</span>
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