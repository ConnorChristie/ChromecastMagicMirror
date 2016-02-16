<?= $this->Form->create($model, ['url' => ['action' => 'update']]) ?>
    <div class="row">
        <?php foreach ($model as $id => $category): ?>
            <div class="col-md-<?= $category->panel_width ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title"><?= $category->name ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        foreach ($category->settings as $setting)
                        {
                            $inputOptions = ['label' => $setting->name, 'default' => $setting->default_value, 'required' => $setting->required];
                            $options = $setting->options;

                            if (!empty($options))
                            {
                                $optionValues = explode(',', $options);
                                $options = [];

                                foreach ($optionValues as $option)
                                {
                                    if (strpos($option, '=') !== false)
                                    {
                                        $keyValue = explode('=', $option);

                                        $options[$keyValue[0]] = $keyValue[1];
                                    } else
                                    {
                                        $options[strtolower($option)] = $option;
                                    }

                                    $inputOptions['options'] = $options;
                                }
                            }

                            echo $this->Form->input($id . '.settings.' . $setting->id . '.setting_value.value', $inputOptions);
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

	<?= $this->Form->submit('Save Settings') ?>
<?= $this->Form->end() ?>