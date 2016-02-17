<?= $this->Form->create($model, ['url' => ['action' => 'update']]) ?>
    <div class="row">
        <?php $row = 0;
        foreach ($model as $id => $category): ?>
            <?= $category->panel_row != $row ? '</div><div class="row">' : '' ?>

            <div class="col-md-<?= $category->panel_width ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title"><?= __($category->name) ?></h3>
                    </div>
                    <div class="panel-body">
                        <?= $this->Settings->inputs($id, $category->settings) ?>
                    </div>
                </div>
            </div>
        <?php $row = $category->panel_row;
        endforeach; ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= __('Actions') ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 clearfix">
                            <?= $this->Form->button(__('Save Settings'), [
                                'name' => 'save_config',
                                'class' => 'btn-info pull-left',
                                'type' => 'submit'
                            ]) ?>

                            <?= $this->Form->button(__('Reload from Config'), [
                                'name' => 'reload_config',
                                'class' => 'btn-primary pull-right',
                                'type' => 'submit',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => __('Use this if you have modified the config manually')
                            ]) ?>
                        </div>
                    </div>

                    <?= $this->Form->input('auto_refresh', ['type' => 'checkbox', 'label' => __('Automatically refresh {0}', [__('{0} Magic Mirror', ['Chromecast'])])]) ?>
                </div>
            </div>
        </div>
    </div>
<?= $this->Form->end() ?>