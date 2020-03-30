<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Usuários</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuário</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- btn -->
    <div class="dash_breadcrumb_btn">
    	<a href="<?php echo base_url('admin/users/new'); ?>" class="btn btn-success btn-xs" title="Novo Usuário">Novo Usuário</a>
    </div>
    <!-- end btn -->
</div>

<div id="content" class="content">
    <div class="row single-users">
        <?php if(empty($users)): ?>
            <div class="col-12">
                <div class="alert alert-dismissible alert-info">
                    <h4>Aviso!</h4>
                    <p>Nenhum <strong>usuário</strong> cadastrado no momento!</p>
                </div>
            </div>
        <?php else: foreach($users as $Users): ?>
            <article class="col-md-3 text-center">
                <div class="box h-100 text-center">
                    <a href="<?php echo base_url('admin/users/update/'.$Users['user_url']); ?>" title="<?php echo $Users["user_name"] ?>">
                        <img class="user-box-img rounded" src="<?php echo ($Users["user_img"] !== null) ? base_url('assets/uploads/users/'.$Users['user_img']) : "/assets/admin/img/user.png" ?>" alt="<?php echo $Users["user_name"]; ?>" title="<?php echo $Users["user_name"]; ?>">
                    </a>
                    <div class="box-content">
                        <header class="box-header">
                            <h1><a href="<?php echo base_url('admin/users/update/'.$Users['user_url']); ?>" title="<?php echo $Users["user_name"]; ?>"><?php echo $Users["user_name"]; ?></a></h1>
                        </header>
                        <div class="box-text">
                            <p class="nivel"><i class="fa fa-tasks"></i> <?php echo $Users["g_name"]; ?></p>
                            <p><i class="fa fa-envelope"></i> <?php echo $Users["user_email"]; ?></p>

                            <p class="<?php echo (($Users["on_data_final"] > date('Y-m-d H:i:s')) ? "text-success" : "text-danger"); ?>"><i class="<?php echo ($Users["on_data_final"] > date('Y-m-d H:i:s') ? "fa fa-circle" : "far fa-circle"); ?>"></i> <?php echo ($Users["on_data_final"] > date('Y-m-d H:i:s') ? "Online" : "Offline"); ?></p>
                        </div>
                    </div>
                    <footer class="box-footer box-footer-dash b-t-1">
                        <a href="<?php echo base_url('admin/users/update/'.$Users['user_url']); ?>" class="btn btn-xs btn-info transition" title="Editar Usuário"><i class="fas fa-user-edit"></i> Editar</a>
                        <span class="btn btn-xs btn-danger transition button_action" rel="Deseja excluir?" callback="users" callback_action='delete' id="<?php echo $Users["user_id"]; ?>" title="Excluir Usuário"><i class="fas fa-times-circle"></i> Excluir</span>
                    </footer>
                </div>
            </article>
        <?php endforeach; endif; ?>
    </div>
</div>