<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Atualizar Grupo de Permissões</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url('admin/permissions'); ?>" title="Permissões">Permissões</a></li>
        <li class="breadcrumb-item active">Atualizar</li>
    </ol>
    <!-- end breadcrumb -->
</div><?php //var_dump($pgroups); die; ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Grupos de Permissão
                </div>
                <div class="panel-body">
                    <?php echo form_open_multipart('admin/permissionsgroup/update', 'class="form-horizontal" id="form"'); ?>
                        <div class="form-group">
                            <label>Nome do Grupo *</label>
                            <input type="text" class="form-control" id="g_name" name="g_name" minlenght="5" value="<?php echo $pgroups->g_name; ?>">
                            <input type="hidden" class="form-control" id="g_id" name="g_id" minlenght="5" value="<?php echo $pgroups->g_id; ?>">
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
                                <input type="checkbox" id="<?php echo $Permission["p_name"] ?>" name="g_check[]" value="<?php echo $Permission["p_id"] ?>" <?php echo (in_array($Permission["p_id"], explode(',', $pgroups->g_params))) ? "checked='checked'" : '' ?> title="<?php echo $Permission["p_name"] ?>"/>
                                <label for="<?php echo $Permission["p_name"] ?>"><?php echo $Permission["p_name"] ?></label>
                            </div>
                        <?php endforeach; endif; ?>
                        </div>

                        <div class="clearfix"></div>

                        <button type="submit" class="btn btn-green">Atualizar <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>