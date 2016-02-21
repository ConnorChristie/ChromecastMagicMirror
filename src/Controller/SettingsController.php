<?php
namespace App\Controller;

use App\Controller\BaseController\NavigationController;
use App\Model\Entity\Category;
use Cake\Network\Exception\BadRequestException;
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
        if ($this->request->is('PUT'))
        {
            $data = $this->request->data;

            if ($this->_validateSettingsForm($data))
            {
                try
                {
                    $success = $this->Extension->saveCategories($data['categories']);
                    $success = $success && $this->Extension->saveSettingValues($data['settings']);

                    if ($success)
                    {
                        $reloadMessage = '';

                        if ($data['auto_refresh'])
                        {
                            $this->Chromecast->refresh();

                            $reloadMessage = ' ' . __('If your Magic Mirror is currently running, it should automatically refresh very soon!');
                        }

                        $this->Flash->success(__('Successfully updated the settings!') . $reloadMessage);
                    } else
                    {
                        $this->Flash->error(__('Unable to save your settings, are you connected to your database?'));
                    }
                } catch (BadRequestException $e)
                {
                    $this->Flash->error(__('Invalid form submission, error: {0}', $e->getMessage()));
                }
            } else
            {
                $this->Flash->error(__('Invalid form submission, try re-submitting the form.'));
            }
        }

        $this->redirect(['action' => 'index']);
    }

    protected function _validateSettingsForm($data)
    {
        if (!isset($data['save_config']) || !isset($data['auto_refresh']))
        {
            return false;
        }

        if (!isset($data['categories']) || !isset($data['settings']))
        {
            return false;
        }

        return true;
    }
}
