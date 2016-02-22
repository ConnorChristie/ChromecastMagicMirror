<?php
namespace App\Controller\Component;

use App\Model\Entity\Category;
use App\Model\Entity\Extension;
use App\Model\Entity\SettingValue;
use Cake\Controller\Component;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\InternalErrorException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

class ExtensionComponent extends Component
{
    private $_propertyNotFound = 'The {0} property for the {1} could not be found.';

    /**
     * Finds all the categories
     *
     * @param string $extensionName The extension to get the categories for
     * @return array The categories and all their settings
     * @throws InternalErrorException Thrown if the extension entry could not be found or there are no categories
     */
    public function getCategories($extensionName)
    {
        $extension = $this->_getExtension($extensionName);
        $categories = $extension->categories;

        if (empty($categories))
        {
            throw new InternalErrorException(
                __('No categories were found for the extension {0}.', $extension->name) .
                '\n' .
                __('Refer to the author\'s help page for help with this extension.')
            );
        }

        $categories = Hash::combine($categories, '{n}.id', '{n}');

        foreach ($categories as $category)
        {
            $category->settings = Hash::combine($category->settings, '{n}.id', '{n}');
        }

        return $categories;
    }

    /**
     * Saves the categories array that was specified
     *
     * @param array $categories An array of categories to save
     * @return bool If the categories were successfully saved
     */
    public function saveCategories($categories)
    {
        $success = true;

        $this->_validateCategoriesData($categories);
        $categoriesTable = TableRegistry::get('Categories');

        foreach ($categories as $id => $category)
        {
            $model = new Category([
                'id' => $id,
                'enabled' => $category['enabled']
            ]);

            $success = $success && $categoriesTable->save($model);
        }

        return $success;
    }

    /**
     * Saves the settings array that was specified
     *
     * @param array $settings An array of settings to save
     * @return bool If the settings were successfully saved
     */
    public function saveSettingValues($settings)
    {
        $success = true;

        $this->_validateSettingsData($settings);
        $settingValuesTable = TableRegistry::get('SettingValues');

        foreach ($settings as $id => $setting)
        {
            $model = new SettingValue([
                'id' => $setting['id'],
                'setting_id' => $id,
                'value' => $setting['value']
            ]);

            $success = $success && $settingValuesTable->save($model);
        }

        return $success;
    }

    /**
     * Validates the categories array
     *
     * @param array $categories The categories array to be validated
     * @return void
     * @throws BadRequestException If the validation fails
     */
    protected function _validateCategoriesData($categories)
    {
        foreach ($categories as $id => $category)
        {
            if (!isset($category['enabled']))
            {
                throw new BadRequestException(__($this->_propertyNotFound, ['enabled', 'category']));
            }
        }
    }

    /**
     * Validates the settings array
     *
     * @param array $settings The settings array to be validated
     * @return void
     * @throws BadRequestException If the validation fails
     */
    protected function _validateSettingsData($settings)
    {
        foreach ($settings as $id => $setting)
        {
            if (!isset($setting['id']))
            {
                throw new BadRequestException(__($this->_propertyNotFound, ['id', 'setting']));
            }

            if (!isset($setting['value']))
            {
                throw new BadRequestException(__($this->_propertyNotFound, ['value', 'setting']));
            }
        }
    }

    /**
     * Gets all the category and setting data for the specified extension
     *
     * @param string $extensionName The extension name
     * @return Extension The extension and all its settings
     * @throws InternalErrorException Thrown if the extension entry could not be found
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
                            'sort' => ['Settings.input_row' => 'ASC', 'Settings.input_column' => 'ASC'],
                            'SettingValues'
                        ]
                    ]
                ]
            ])
            ->where(['Extensions.short_name' => $extensionName])
            ->first();

        if ($extension == null)
        {
            $helpPage = ['<a href="/help">', '</a>'];

            throw new InternalErrorException(
                __('The extension {0} does not exist in the database.', $extensionName) .
                '\n' .
                __('Try reading the {0}Help{1} page for more information.', [$helpPage[0], $helpPage[1]])
            );
        }

        return $extension;
    }
}
