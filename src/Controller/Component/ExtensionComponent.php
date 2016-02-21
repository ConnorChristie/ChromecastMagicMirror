<?php
namespace App\Controller\Component;

use App\Model\Entity\Extension;
use App\Model\Entity\SettingValue;
use Cake\Controller\Component;
use Cake\Network\Exception\InternalErrorException;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class ExtensionComponent extends Component
{
    /**
     * Finds all the categories
     *
     * @param string $extensionName The extension to get the categories for
     * @return array The categories and all their settings
     * @throws InternalErrorException Thrown if the extension entry could no be found or there are no categories
     */
    public function getCategories($extensionName)
    {
        $extension = $this->_getExtension($extensionName);
        $categories = $extension->categories;

        if (empty($categories)) {
            throw new InternalErrorException(
                __('No categories were found for the extension {0}.', $extension->name) .
                '\n' .
                __('Refer to the author\'s help page for help with this extension.')
            );
        }

        $categories = Hash::combine($categories, '{n}.id', '{n}');

        foreach ($categories as $category) {
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
    public function saveSettingValues($data, Table $settingValuesTable)
    {
        $success = true;

        foreach ($data['settings'] as $settingId => $setting) {
            $model = new SettingValue([
                'id' => $setting['id'],
                'setting_id' => $settingId,
                'value' => $setting['value']
            ]);

            if (!$settingValuesTable->save($model)) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Gets all the category and setting data for the specified extension
     *
     * @param string $extensionName The extension name
     * @return Extension The extension and all its settings
     */
    protected function _getExtension($extensionName)
    {
        $extensionsTable = TableRegistry::get('Extensions');

        $extension = $extensionsTable
            ->find('all', [
                'contain' => [
                    'Categories' => [
                        'sort' => ['Categories.panel_row' => 'ASC', 'Categories.panel_column' => 'ASC'],
                        'Settings' => [
                            'SettingValues'
                        ]
                    ]
                ]
            ])
            ->where(['Extensions.short_name' => $extensionName])
            ->first();

        if ($extension == null) {
            $helpPage = ['<a href="/help">', '</a>'];

            throw new InternalErrorException(
                __('The extension {0} does not exist in the database.', $extensionName) .
                '\n' .
                __('Try reading the {0}Help{1} page for more information.', [$helpPage[0], $helpPage[1]]));
        }

        return $extension;
    }
}
