<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Atualizar Usuário</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/users'); ?>" title="Usuários">Usuários</a></li>
        <li class="breadcrumb-item active">Atualizar Usuário</li>
    </ol>
    <!-- end breadcrumb -->
</div>

<div class="content dash_form">
    <?php echo form_open_multipart('admin/users/update', 'class="form-horizontal" id="form"'); ?>
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
                            <input type="text" class="form-control" id="user_name" name="user_name" minlenght="5" value="<?php echo $user_url->user_name; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="control-label">Email *</label>
                            <input type="text" class="form-control" id="user_email" name="user_email" value="<?php echo $user_url->user_email; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="control-label">Login *</label>
                            <input type="text" class="form-control" id="user_login" name="user_login" min="4" maxlength="10" value="<?php echo $user_url->user_login; ?>">
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
                                <?php foreach ($status as $St) : ?>
                                    <option value="<?php echo $St['st_id']; ?>"
                                    <?php echo (($user_url->user_status === $St['st_id']) ? 'selected="selected"' : ""); ?>
                                    ><?php echo $St['st_title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label">Nível de Acesso *</label>
                            <select class="form-control" id="user_level" name="user_level">
                                <option value="">- Selecione o Nível de Acesso -</option>
                                <?php foreach ($level as $l) : ?>
                                    <option value="<?php echo $l['g_id']; ?>"
                                    <?php echo (($user_url->user_level === $l['g_id']) ? 'selected="selected"' : ""); ?>
                                    ><?php echo $l['g_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="control-label">Observação</label>
                            <textarea class="form-control" id="user_obs" name="user_obs" rows="8"><?php echo $user_url->user_obs; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4">
            <div class="panel">
                <figure class="text-center">
                    <?php
                    if (empty($user_url->user_img)) :
                        echo assets_img('admin/img', 'avatar.jpg', ['alt' => 'teste', 'title' => 'teste', 'class' => 'img-fluid', 'id' => 'previewing']);
                    else :
                        echo assets_img('uploads/users', $user_url->user_img, ['alt' => $user_url->user_name, 'title' => $user_url->user_name, 'class' => 'img-fluid', 'id' => 'previewing']);
                    endif;
                    ?>
                </figure>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="control-label">FOTO <span>(500 X 500PX, JPG OU PNG)</span></label>
                            <input type="file" class="form-control" id="img" name="user_img">
                        </div>

                        <div class="col-12 form-group">
                            <button type="submit" class="btn btn-green">Cadastrar <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>