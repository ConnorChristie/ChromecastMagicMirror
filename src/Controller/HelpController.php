<?php

namespace App\Controller;

use App\Controller\BaseController\NavigationController;

class HelpController extends NavigationController
{
    /**
     * Renders the help page
     *
     * @return void
     */
    public function index()
    {
        $this->render('index');
    }
}
