<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Permissões</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active">Permissões</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- btn -->
    <div class="dash_breadcrumb_btn">
    	<a href="<?php echo base_url('admin/permissions/group') ?>" class="btn btn-primary btn-xs" title="Adicionar Grupo">Adicionar Grupo</a>
    	<a href="<?php echo base_url('admin/permissions/permission') ?>" class="btn btn-success btn-xs" title="Adicionar Permissão">Adicionar Permissão</a>
    </div>
    <!-- end btn -->
</div>

<div class="content" id="permissions">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Grupos de Permissão</div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <?php if(empty($g_permission)): ?>
                        <div class="alert alert-dismissible alert-info">
                            <h4>Aviso!</h4>
                            <p>Nenhum <strong>grupo</strong> cadastrado no momento!</p>
                        </div>
                        <?php else: ?>
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($g_permission as $Permissions): ?>
                                <tr>
                                    <td><?= $Permissions["g_id"] ?></td>
                                    <td><?= $Permissions["g_name"] ?></td>
                                    <td class="p_action">
                                        <a href="permissions/group/<?= $Permissions["g_url"] ?>" class="btn btn-primary btn-xs" title="Editar"><i class="fas fa-pen-square"></i></a>
                                        <span class="btn btn-danger btn-xs button_action" rel="Deseja excluir?" callback="permissions" callback_action='delete' id="<?= $Permissions["g_id"] ?>" title="Deseja excluir?"><i class="fas fa-times-circle"></i></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">Permissões</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php if(empty($permission)): ?>
                        <div class="alert alert-dismissible alert-info">
                            <h4>Aviso!</h4>
                            <p>Nenhuma <strong>permissão</strong> cadastrada no momento!</p>
                        </div>
                        <?php else: ?>
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($permission as $Permissions): ?>
                                <tr>
                                    <td><?= $Permissions["p_id"] ?></td>
                                    <td><?= $Permissions["p_name"] ?></td>
                                    <td class="p_action">
                                        <a href="permissions/permission/<?= $Permissions["p_url"] ?>" class="btn btn-primary btn-xs" title="Editar"><i class="fas fa-pen-square"></i></a>
                                        <span class="btn btn-danger btn-xs button_action" rel="Deseja excluir?" callback="permissions" callback_action='p-delete' id="<?= $Permissions["p_id"] ?>" title="Deseja excluir?"><i class="fas fa-times-circle"></i></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>