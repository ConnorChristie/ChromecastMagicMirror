<?= $this->Form->create($model, ['url' => ['action' => 'update']]) ?>
    <div class="row">
        <?php foreach ($model as $id => $category): ?>
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
        <?php endforeach; ?>
    </div>

	<?= $this->Form->submit(__('Save Settings')) ?>
<?= $this->Form->end() ?>