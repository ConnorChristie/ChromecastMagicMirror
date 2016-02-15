<?= $this->Form->create($model, ['url' => ['action' => 'update']]) ?>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading clearfix">
					<h3 class="panel-title">Magic Mirror Settings</h3>
				</div>
				<div class="panel-body">

					<?= $this->Form->input('general.name', ['required' => true]) ?>

					<?= $this->Form->input('general.default_value', ['required' => true]) ?>

					<?= $this->Form->input('general.language', ['options' => ['English', 'Spanish'], 'required' => true]) ?>

					<?= $this->Form->input('general.time_format', ['options' => ['12' => '12 Hour', '24' => '24 Hour'], 'required' => true]) ?>

					<?= $this->Form->input('general.rotation', ['options' => ['Portrait', 'Landscape'], 'required' => true]) ?>

					<div class="form-group required">
						<label class="control-label" for="receiver_ip">Receiver IP Address (If changed, refresh and re-cast)</label>
						<select class="form-control" id="receiver_ip" name="general[appId]">

						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->Form->submit('Save Settings') ?>
<?= $this->Form->end() ?>