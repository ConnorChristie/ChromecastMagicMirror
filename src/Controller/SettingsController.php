<?php
namespace App\Controller;

use App\Model\Entity\Settings;

class SettingsController extends AppController
{
    /**
     * Renders the settings index
     *
     * @return void
     */
    public function index()
    {
        $model = new Settings();

        $this->renderModelView('index', $model);
    }

    /**
     * Updates the settings with the submitted form data
     *
     * @return void
     */
    public function update()
    {
        $model = new Settings();

        if ($this->request->is('POST')) {
            $this->Settings->patchEntity(
                $model, $this->request->data, [
                'associated' => [
                    'General'
                ]
                ]
            );

            //$this->Settings->save($model);

            $this->Flash->success('Successfully updated the settings! ' . print_r($model, true));
        }

        $this->redirect(['action' => 'index']);
    }
}
