<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Grupo de Permissões</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url('admin/permissions') ?>" title="Permissões">Permissões</a></li>
        <li class="breadcrumb-item active">Grupo de Permissões</li>
    </ol>
    <!-- end breadcrumb -->
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Grupos de Permissão
                </div>
                <div class="panel-body">
                    <?php echo form_open_multipart('admin/permissionsgroup/create', 'class="form-horizontal" id="form"'); ?>
                        <div class="form-group">
                            <label>Nome do Grupo *</label>
                            <input class="form-control" type="text" id="g_name" name="g_name" minlenght="5">
                        </div>

                        <div class="form-group">
                            <label><strong>Escolha pelo menos uma permissão:</strong></label>
                            <?php if(!$permissions): ?>
                            <div class="alert alert-dismissible alert-info">
                                <h4>Aviso!</h4>
                                <p>Nenhuma <strong>permissão</strong> cadastrada no momento!</p>
                            </div>
                            <?php else: foreach($permissions as $Permission): ?>
                            <div class="checkbox checkbox-css">
                                <input type="checkbox" id="<?= $Permission["p_name"] ?>" name="g_check[]" value="<?= $Permission["p_id"] ?>" title="<?= $Permission["p_name"] ?>"/>
                                <label for="<?= $Permission["p_name"] ?>"><?= $Permission["p_name"] ?></label>
                            </div>
                        <?php endforeach; endif; ?>
                        </div>

                        <div class="clearfix"></div>

                        <button type="submit" class="btn btn-green">Cadastrar <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>