<?php
namespace App\Controller;

use App\Model\Entity\SettingValue;
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

        $categories = $categoriesTable->find('all')->orderAsc('panel_row, panel_column')->contain(['Settings' => ['SettingValues']])->all()->toArray();
        $categories = Hash::combine($categories, '{n}.id', '{n}');

        foreach ($categories as $category) {
            $category->settings = Hash::combine(Hash::sort($category->settings, '{n}.id', 'asc'), '{n}.id', '{n}');
        }

        $this->set(compact('categories'));
        $this->renderModelView('index', $categories);
    }

    /**
     * Updates the settings with the submitted form data
     *
     * @return void
     */
    public function update()
    {
        $model = new SettingValue();

        if ($this->request->is('PUT')) {
            $settingsTable = TableRegistry::get('SettingValues');

            $settingsTable->patchEntity($model, $this->request->data, [
                'associated' => [
                    'Settings' => ['Categories']
                ]
            ]);

            //$this->Settings->save($model);

            $this->Flash->success('Successfully updated the settings! ' . print_r($model, true));
        }

        $this->redirect(['action' => 'index']);
    }
}
