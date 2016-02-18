<?php
namespace App\Controller;

use App\Model\Entity\SettingValue;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class SettingsController extends AppController
{
    /**
     * Renders the settings index
     *
     * @return void
     */
    public function index()
    {
        $categoriesTable = TableRegistry::get('Categories');
        $categories = $this->_getCategories($categoriesTable);

        $this->renderModelView('index', $categories);
    }

    /**
     * Updates the settings with the submitted form data
     *
     * @return void
     */
    public function update()
    {
        if ($this->request->is('PUT')) {
            $data = $this->request->data;
            $settingValuesTable = TableRegistry::get('SettingValues');

            $success = $this->_saveSettingValues($data, $settingValuesTable);

            if ($success) {
                $reload_message = '';

                if ($data['auto_refresh']) {
                    $this->_refreshChromecast();

                    $reload_message = ' ' . __('If your Magic Mirror is currently running, it should automatically refresh very soon!');
                }

                $this->Flash->success(__('Successfully updated the settings!') . $reload_message);
            } else {
                $this->Flash->error(__('Unable to save your settings, are you connected to your database?'));
            }
        }

        $this->redirect(['action' => 'index']);
    }

    /**
     * Finds all the categories
     *
     * @param Table $categoriesTable The categories database table
     * @return array The categories and all their settings
     */
    protected function _getCategories($categoriesTable)
    {
        $categories = $categoriesTable->find('all')->orderAsc('panel_row, panel_column')->contain(['Settings' => ['SettingValues']])->all()->toArray();
        $categories = Hash::combine($categories, '{n}.id', '{n}');

        foreach ($categories as $category)
        {
            $category->settings = Hash::combine(Hash::sort($category->settings, '{n}.id', 'asc'), '{n}.id', '{n}');
        }
        return $categories;
    }

    /**
     * Saves the setting values from the posted form
     *
     * @param array $data The posted date from the settings form
     * @param Table $settingValuesTable The setting values table
     * @return bool If the settings were successfully saved
     */
    protected function _saveSettingValues($data, $settingValuesTable)
    {
        $success = true;

        foreach ($data['settings'] as $setting_id => $setting)
        {
            $model = new SettingValue([
                'id' => $setting['id'],
                'setting_id' => $setting_id,
                'value' => $setting['value']
            ]);

            if (!$settingValuesTable->save($model))
            {
                $success = false;
            }
        }
        return $success;
    }

    /**
     * Refreshes the Chromecast
     *
     * @return void
     */
    protected function _refreshChromecast()
    {
        // Todo: Refresh Chromecast
    }
}
