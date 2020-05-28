<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Páginas</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->    
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active">Páginas</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- btn -->
    <div class="dash_breadcrumb_btn">
    	<a href="<?php echo base_url('admin/page/new'); ?>" class="btn btn-success btn-xs" title="Nova Página">Nova Página</a>
    </div>
    <!-- end btn -->
</div>

<div class="content">
	<div class="row">
        <div class="col-md-12 dash_pages">
            <?php if(empty($pages)): ?>
                <div class="alert alert-dismissible alert-info">
                    <h4>Aviso!</h4>
                    <p>Nenhuma <strong>página</strong> cadastrada no momento!</p>
                </div>
            <?php
            else:
                foreach($pages as $page):
            ?>
            
            <section class="dash_pages_section">
                <header class="dash_pages_section_header">
                    <h1><?php echo $page["Pages"]["page_title"] ?></h1>
                </header>
                <div class="dash_pages_section_content">
                    <p><?php echo $page["Pages"]["page_desc"] ?></p>
                    <p>
                        <a href="<?php echo base_url('admin/page/view/'.$page["Pages"]["page_url"]) ?>" class="btn btn-primary btn-xs btn-outline" title="Editar página"><i class="fas fa-pen-square"></i> Editar</a>
                                   
                        <span class="btn btn-danger btn-xs btn-outline button_action" rel="Deseja excluir?" callback="page" callback_action='delete' id="<?php echo $page["Pages"]["page_id"] ?>" title="Excluir página"><i class="fas fa-times-circle"></i> Excluir</span>
                    </p>
                </div>
                <section class="dash_pages_section_sub">
                    <header class="dash_pages_section_sub_header">
                        <h2>Páginas Filha</h2>
                    </header>
                    <?php if(!$page["subPages"]): ?>
                        <div class="alert alert-info">
                            <p>Não existem páginas filhas para essa página.</p>
                        </div>
                    <?php else: foreach($page["subPages"] as $subPages): ?>
                        <article class="dash_pages_section_sub_article">
                            <header class="dash_pages_section_sub_article_header">
                                <h1><?php echo $subPages["page_title"] ?></h1>
                            </header>
                            <div class="dash_pages_section_sub_article_content">                            
                                <p><?php echo $subPages["page_desc"] ?></p>
                                <p>
                                    <a href="<?php echo base_url('admin/page/view/'.$subPages["page_url"]) ?>" class="btn btn-primary btn-xs btn-outline" title="Editar página"><i class="fas fa-pen-square"></i> Editar</a>
                                   
                                    <span class="btn btn-danger btn-xs btn-outline button_action" rel="Deseja excluir?" callback="page" callback_action='delete' id="<?php echo $subPages["page_id"] ?>" title="Excluir página"><i class="fas fa-times-circle"></i> Excluir</span>
                                </p>
                            </div>
                        </article>
                    <?php endforeach; endif; ?>
                </section>
            </section>        
        <?php endforeach; ?>
        <?php endif;?>   
    </div>     
    </div>
</div>