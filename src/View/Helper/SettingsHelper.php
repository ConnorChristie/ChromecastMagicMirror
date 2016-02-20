<?php
namespace App\View\Helper;

use Cake\View\Helper;

class SettingsHelper extends Helper
{
    public $helpers = ['Html', 'Form'];

    /**
     * Creates the category panel header with an enable/disable switch is specified
     *
     * @param string $categoryName The category name
     * @param bool $showEnableDisableSwitch Whether to show the enable/disable switch or not
     * @param int $categoryId The category ID
     * @param bool $enabled If the switch is enabled or disabled
     * @return string The HTML for the panel header
     */
    public function panelHeader($categoryName, $showEnableDisableSwitch = false, $categoryId = 0, $enabled = false)
    {
        $title = $this->Html->tag('h3', $categoryName, [
            'class' => 'panel-title panel-category' . ($showEnableDisableSwitch ? ' pull-left' : '')
        ]);

        $enableDisableSwitch = '';

        if ($showEnableDisableSwitch) {
            $enableDisableSwitch = $this->enableDisableSwitch($categoryId, $enabled);
        }

        return $this->Html->div('panel-heading' . ($showEnableDisableSwitch ? ' clearfix' : ''), $title . $enableDisableSwitch);
    }

    /**
     * Creates the enable/disable switch
     *
     * @param int $categoryId The category ID
     * @param bool $enabled If this category is enabled
     * @return string The HTML for the switch
     */
    public function enableDisableSwitch($categoryId, $enabled)
    {
        $yesClasses = $enabled ? ' btn-success active' : ' btn-warning';
        $noClasses = !$enabled ? ' btn-warning active' : ' btn-success';

        $yesChecked = $enabled ? 'checked' : '';
        $noChecked = !$enabled ? 'checked' : '';

        $yesInput = $this->Html->tag('input', '', [
            'type' => 'radio',
            'name' => 'categories[' . $categoryId . '][enabled]',
            'value' => 1,
            'autocomplete' => 'off',
            $yesChecked
        ]);

        $noInput = $this->Html->tag('input', '', [
            'type' => 'radio',
            'name' => 'categories[' . $categoryId . '][enabled]',
            'value' => 0,
            'autocomplete' => 'off',
            $noChecked
        ]);

        $yesLabel = $this->Html->tag('label', $yesInput . ' ' . __('Enabled'), ['class' => 'btn btn-xs' . $yesClasses]);
        $noLabel = $this->Html->tag('label', $noInput . ' ' . __('Disabled'), ['class' => 'btn btn-xs' . $noClasses]);

        return $this->Html->div('btn-group pull-right category-switch', $yesLabel . $noLabel, [
            'data-toggle' => 'buttons'
        ]);
    }

    /**
     * Creates all the inputs for the specified settings
     *
     * @param int $categoryId The current category it
     * @param array $settings The settings for that category
     * @return string The HTML for the inputs
     */
    public function inputs($categoryId, array $settings)
    {
        $html = '';

        foreach ($settings as $setting) {
            $inputOptions = ['label' => __($setting->name), 'default' => $setting->default_value, 'required' => $setting->required];
            $options = $setting->options;

            if (!empty($options)) {
                $arr = unserialize($options);

                if ($arr !== false) {
                    foreach ($arr as $key => $value) {
                        $arr[$key] = __($value);
                    }

                    $inputOptions['options'] = $arr;
                }
            }

            $hiddenOptions = ['name' => 'settings[' . $setting->id . '][id]'];
            $inputOptions['name'] = 'settings[' . $setting->id . '][value]';

            $html .= $this->Form->hidden($categoryId . '.settings.' . $setting->id . '.setting_value.id', $hiddenOptions);
            $html .= $this->Form->input($categoryId . '.settings.' . $setting->id . '.setting_value.value', $inputOptions);
        }

        return $html;
    }
}
