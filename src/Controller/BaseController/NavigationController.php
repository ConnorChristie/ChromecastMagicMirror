<?php
namespace App\Controller\BaseController;

class NavigationController extends AppController
{
    /**
     * Initialize the controller with the navigation component
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Navigation');
    }
}
