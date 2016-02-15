<?php

namespace App\Controller;

class HelpController extends AppController
{
    /**
     * Renders the help page
     */
    public function index()
    {
        $this->render('index');
    }
}
