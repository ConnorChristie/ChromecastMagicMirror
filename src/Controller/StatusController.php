<?php
namespace App\Controller;

use App\Controller\BaseController\NavigationController;

class StatusController extends NavigationController
{
    public function index()
    {
        $this->renderModelView('index');
    }
}
