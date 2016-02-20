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
        $categoriesTable = TableRegistry::get('Categories');
        $settings = $this->_getSettings($categoriesTable);

        $this->set('settings', $settings);
        $this->set('_serialize', 'settings');
    }

    /**
     * Finds all the categories
     *
     * @param Table $categoriesTable The categories database table
     * @return array The categories and all their settings
     */
    protected function _getSettings(Table $categoriesTable)
    {
        $categories = $categoriesTable
            ->find('all', [
                'fields' => ['Categories.id', 'Categories.short_name', 'Categories.enabled'],
                'contain' => [
                    'Settings' => [
                        'fields' => ['Settings.short_name', 'Settings.category_id', 'Settings.default_value'],
                        'SettingValues' => [
                            'fields' => ['SettingValues.value']
                        ]
                    ]
                ]
            ])
            ->orderAsc('panel_row, panel_column')
            ->all()
            ->toArray();

        $categories = Hash::combine($categories, '{n}.short_name', '{n}');

        foreach ($categories as $category) {
            $category->settings = Hash::combine($category->settings, '{n}.short_name', '{n}');
        }

        return $categories;
    }
}
