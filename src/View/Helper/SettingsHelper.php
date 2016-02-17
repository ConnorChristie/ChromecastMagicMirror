<?php
namespace App\View\Helper;

use Cake\View\Helper;

class SettingsHelper extends Helper
{
    public $helpers = ['Form'];

    public function inputs($category_id, array $settings)
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

            $html .= $this->Form->input($category_id . '.settings.' . $setting->id . '.setting_value.value', $inputOptions);
        }

        return $html;
    }
}
