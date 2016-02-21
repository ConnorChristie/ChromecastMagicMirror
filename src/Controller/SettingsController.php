<?php
namespace App\Controller;

use App\Controller\BaseController\NavigationController;
use App\Model\Entity\Category;
use Cake\ORM\TableRegistry;

class SettingsController extends NavigationController
{
    public $components = ['Extension', 'Chromecast'];

    /**
     * Renders the settings index
     *
     * @return void
     */
    public function index()
    {
        $categories = $this->Extension->getCategories('settings');
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

            $categoriesTable = TableRegistry::get('Categories');
            $settingValuesTable = TableRegistry::get('SettingValues');

            $success = true;

            foreach ($data['categories'] as $id => $category) {
                $model = new Category([
                    'id' => $id,
                    'enabled' => $category['enabled']
                ]);

                $success = $categoriesTable->save($model);
            }

            $success = $success && $this->Extension->saveSettingValues($data, $settingValuesTable);

            if ($success) {
                $reloadMessage = '';

                if ($data['auto_refresh']) {
                    $this->Chromecast->refresh();

                    $reloadMessage = ' ' . __('If your Magic Mirror is currently running, it should automatically refresh very soon!');
                }

                $this->Flash->success(__('Successfully updated the settings!') . $reloadMessage);
            } else {
                $this->Flash->error(__('Unable to save your settings, are you connected to your database?'));
            }
        }

        $this->redirect(['action' => 'index']);
    }
}
