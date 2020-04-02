<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Novo Usuário</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/users'); ?>" title="Usuários">Usuários</a></li>
        <li class="breadcrumb-item active">Cadastrar Usuário</li>
    </ol>
    <!-- end breadcrumb -->
</div>

<div class="content dash_form">
    <?php echo form_open_multipart('admin/users/create', 'class="form-horizontal" id="form"'); ?>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-info-circle"></i> Perfil</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="control-label">Nome Completo *</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" minlenght="5">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label">Email *</label>
                                <input type="text" class="form-control" id="user_email" name="user_email">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="control-label">Login *</label>
                                <input type="text" class="form-control" id="user_login" name="user_login" min="4" maxlength="10">
                            </div>
                        
                            <div class="col-md-6 form-group">
                                <label class="control-label">Senha *</label>
                                <input type="password" class="form-control" id="user_pass" name="user_pass" min="4" maxlength="12">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="control-label">Confirmar Senha *</label>
                                <input type="password" class="form-control" id="user_cpass" name="user_cpass" min="4" maxlength="12">
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label class="control-label">Status *</label>
                                <select class="form-control" id="user_status" name="user_status">
                                    <option value="">- Selecione o Status -</option>
                                    <?php
                                    foreach ($status as $St):
                                        echo "<option value=\"{$St['st_id']}\">{$St['st_title']}</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="control-label">Nível de Acesso *</label>
                                <select class="form-control" id="user_level" name="user_level">
                                    <option value="">- Selecione o Nível de Acesso -</option>
                                    <?php
                                    foreach ($level as $l):
                                        echo "<option value=\"{$l['g_id']}\">{$l['g_name']}</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="control-label">Observação</label>
                                <textarea class="form-control" id="user_obs" name="user_obs" rows="8"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4">
                <div class="panel">
                    <figure class="text-center">
                        <?php echo assets_img('admin/img', 'avatar.jpg', ['alt' => 'teste', 'title' => 'teste', 'class' => 'img-fluid', 'id' => 'previewing']); ?>
                    </figure>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-12 form-group">
                                <label class="control-label">FOTO <span>(500 X 500PX, JPG OU PNG)</span></label>
                                <input type="file" class="form-control" id="img" name="user_img">
                            </div>

                            <div class="col-12 form-group mb-0">
                                <button type="submit" class="btn btn-green">Cadastrar <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>