<?php
namespace App\View\Helper;

use Cake\View\Helper;

class SettingsHelper extends Helper
{
    public $helpers = ['Form'];

    /**
     * Creates all the inputs for the specified settings
     *
     * @param int $categoryId The current category it
     * @param array $settings The settings for that category
     * @return string
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
