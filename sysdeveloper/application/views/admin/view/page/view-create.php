<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Nova Página</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/page'); ?>" title="Páginas">Páginas</a></li>
        <li class="breadcrumb-item active">Cadastrar Página</li>
    </ol>
    <!-- end breadcrumb -->
</div>

<div class="content dash_form">
    <div class="row">
		<div class="col-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<i class="fa fa-info-circle"></i> Informações da Página
				</div>
				<?php echo form_open_multipart('admin/page/create', 'class="form-horizontal" id="form"'); ?>
					<div class="panel-body">
						<div class="row">
							<div class="col-12 form-group">
								<label class="control-label">Nome *</label>
								<input type="text" class="form-control" id="page_title" name="page_title" placeholder="Nome da Página">
							</div>
							
							<div class="col-12 form-group">
								<label class="control-label">Breve Descrição *</label>
								<textarea class="form-control text-area" id="page_desc" name="page_desc" placeholder="Uma breve descrição da Página" rows="4" maxlength="160"></textarea>
								<span class="help-block"><p id="characterLeft" class="help-block ">Você atingiu o limite</p></span>
							</div>
							
							<div class="col-12 form-group">
								<label class="control-label">Página Filha</label>
								<select class="form-control" id="page_parent" name="page_parent">
									<option value="0">-- Selecione uma Página --</option>
									<?php
										foreach($pages as $Page):
											echo "<option value=\"{$Page['page_id']}\">{$Page['page_title']}</option>";
										endforeach;
									?>
								</select>
							</div>
							
							<div class="col-12 form-group">
								<label class="control-label">Texto/Informações *</label>
								<textarea class="form-control tiny-content" id="page_content" name="page_content" rows="10"></textarea>
							</div>
							
							<div class="col-12 form-group">
								<button type="submit" class="btn btn-green">Cadastrar <i class="fa fa-spinner fa-spin fa-fw form_load" style="display:none;"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>