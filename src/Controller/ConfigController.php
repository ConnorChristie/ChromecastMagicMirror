<?php
namespace App\Controller;

use App\Controller\BaseController\APIController;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class ConfigController extends APIController
{
    /**
     * Returns the config settings as json
     *
     * @return void
     */
    public function index()
    {
        $extensionsTable = TableRegistry::get('Extensions');
        $settings = $this->_getSettings($extensionsTable);

        $this->set('settings', $settings);
        $this->set('_serialize', 'settings');
    }

    /**
     * Finds all the categories
     *
     * @param Table $extensionsTable The extensions database table
     * @return array The categories and all their settings
     */
    protected function _getSettings(Table $extensionsTable)
    {
        $extensions = $extensionsTable
            ->find('all', [
                'fields' => ['Extensions.id', 'Extensions.short_name'],
                'contain' => [
                    'Categories' => [
                        'fields' => ['Categories.id', 'Categories.extension_id', 'Categories.short_name', 'Categories.enabled'],
                        'Settings' => [
                            'fields' => ['Settings.short_name', 'Settings.category_id', 'Settings.default_value'],
                            'SettingValues' => [
                                'fields' => ['SettingValues.value']
                            ]
                        ]
                    ]
                ]
            ])
            ->all()
            ->toArray();

        $extensions = Hash::combine($extensions, '{n}.short_name', '{n}');

        foreach ($extensions as $extension) {
            $extension->categories = Hash::combine($extension->categories, '{n}.short_name', '{n}');

            foreach ($extension->categories as $category) {
                $category->settings = Hash::combine($category->settings, '{n}.short_name', '{n}');

                foreach ($category->settings as $setting) {
                    if (isset($setting->setting_value->value)) {
                        $setting->setting_value = $setting->setting_value->value;
                    }
                }
            }
        }

        return $extensions;
    }
}
