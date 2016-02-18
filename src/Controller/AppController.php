<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\Entity;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $helpers = [
        'Html' => [
            'className' => 'Bootstrap.BootstrapHtml'
        ],
        'Form' => [
            'className' => 'Bootstrap.BootstrapForm'
        ],
        'Flash' => [
            'className' => 'Bootstrap.BootstrapFlash'
        ],
        'Paginator' => [
            'className' => 'Bootstrap.BootstrapPaginator'
        ],
        'Modal' => [
            'className' => 'Bootstrap.BootstrapModal'
        ]
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Navigation');
    }

    /**
     * Renders the specified view with the model
     *
     * @param  string $view   The view to render
     * @param  Entity $model  The model to pass to the view
     * @param  string $layout The layout to use for the view
     * @return \Cake\Network\Response
     */
    public function renderModelView($view = null, $model = null, $layout = null)
    {
        $this->set(compact('model'));

        return parent::render($view, $layout);
    }

    /**
     * Before render callback.
     *
     * @param  \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }
    }
}
