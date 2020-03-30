<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active">Acesso Negado</li>
    </ol>
    <!-- end breadcrumb -->

    <div class="py-3 mt-5">
        <div class="col-12 text-center">
            <img class="img-fluid mb-3" src="<?php echo base_url('assets/admin/img/bloqueio.png'); ?>" alt="Acesso NÃO permitido" title="Acesso NÃO permitido!" width="300px">
            <h1><strong>Acesso NÃO permitido!</strong></h1>

            <div>
                <p><strong><?php echo $this->session->userOnline["user_name"] ?></strong>, você não tem permissão para acessar esta página.</p>
                <a href="javascript:history.back()" class="btn btn-sm btn-primary">Voltar</a>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->