<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Cadastrar Permissão</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="<?php echo base_url('admin/permissions') ?>" title="Permissões">Permissões</a></li>
        <li class="breadcrumb-item active">Cadastrar Permissão</li>
    </ol>
    <!-- end breadcrumb -->
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Cadastrar Permissão
                </div>
                <div class="panel-body">
                    <?php echo form_open_multipart('admin/permissions/create', 'class="form-horizontal" id="form"'); ?>
                        <div class="form-group">
                            <label>Nome da Permissão *</label>
                            <input type="text" class="form-control" id="p_name" name="p_name" minlenght="5">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Cadastrar <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>