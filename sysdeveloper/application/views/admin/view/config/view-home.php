<div class="dash_breadcrumb row justify-content-between align-items-center">
    <!-- begin page-header -->
    <header class="dash_breadcrumb_header">
        <h1 class="page-header">Configuração Geral</h1>
    </header>
    <!-- end page-header -->
    <!-- begin breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>" title="Painel Inicial">Dashboard</a></li>
        <li class="breadcrumb-item active">Configuração</li>
    </ol>
    <!-- end breadcrumb -->
</div>

<div class="content dash_config">
    <div class="row flex-row-reverse">
        <div class="col-12 col-sm-12 col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">MENU</div>
                <div class="panel-body">
                    <ul class="nav nav-pills">
                        <?php
                            $iMenu = 0;
                            foreach($configs as $group):
                                $Active = ($iMenu == 0 ? 'active show' : null);
                                $iMenu++;
                        ?>
                            <li class="nav-items">
                                <a href="#<?= $group['conf_type'] ?>" data-toggle="tab" class="nav-link <?= $Active ?>" title="<?= $group['conf_type'] ?>">
                                    <span class="d-sm-none"><?= $group['conf_type'] ?></span>
                                    <span class="d-sm-block d-none"><?= $group['conf_type'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>                                
                    </ul>
                </div>
            </div>            
        </div>

        <div class="col-12 col-sm-12 col-md-8 tab-content">
            <?php
                $iForm = 0;
                foreach($configs as $group):
                    $Active = ($iForm == 0 ? 'active show   ' : null);
                    $iForm++;
            ?>

            <div class="panel panel-primary tab-pane <?= $Active ?>" id="<?= $group['conf_type'] ?>">
                <div class="panel-heading"><i class="fa fa-gear"></i> <?= $group['conf_type'] ?></div>
                <div class="panel-body">
                    <?php foreach($this->configurations->getConfigurationsTypes($group["conf_type"]) as $list): ?>
                        <form class="auto_save" id="form" method="post" action="configuration/update" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label"><?= $list['conf_key'] ?></label>
                                <small><strong>OBS:</strong> <?= $list['conf_comments'] ?></small>
                                <input class="form-control" type="text" id="conf_value" name="conf_value" value="<?= $list['conf_value'] ?>">
                                <input type="hidden" id="conf_id" name="conf_id" value="<?= $list['conf_id'] ?>">
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>