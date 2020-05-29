<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Artigos</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active">Artigos</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- btn -->
    <div class="dash_breadcrumb_btn">
        <a href="<?php echo base_url('admin/posts/new'); ?>" class="btn btn-success btn-xs" title="Novo Artigo">Novo Artigo</a>
    </div>
    <!-- end btn -->
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) : ?>
                        <tr>
                            <td><?= $post->post_id ?></td>
                            <td><?= $post->post_title ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $links; ?>
        </div>
    </div>
</div>