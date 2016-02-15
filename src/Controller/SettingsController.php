<?php
namespace App\Controller;

use App\Model\Entity\Settings;

class SettingsController extends AppController
{
    public function index()
    {
        $model = new Settings();

	    $model->title = 'General';
	    $model->category = 1;

	    $this->Settings->save($model);

        $this->renderModelView('index', $model);
    }

    public function update()
    {
	    $model = new Settings();

	    if ($this->request->is('POST'))
	    {
			$this->Settings->patchEntity($model, $this->request->data, [
				'associated' => [
					'General'
				]
			]);

		    $this->Settings->save($model);

		    $this->Flash->success('Successfully updated the settings! ' . print_r($model, true));
	    }

		$this->redirect(['action' => 'index']);
    }
}