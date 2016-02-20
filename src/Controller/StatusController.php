<?php
namespace App\Controller;

use App\Controller\BaseController\NavigationController;

class StatusController extends NavigationController
{
    /**
     * The main index page for the status
     *
     * @return void
     */
    public function index()
    {
        $this->renderModelView('index');
    }
}
