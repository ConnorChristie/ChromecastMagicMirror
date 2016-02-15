<?php

namespace App\Controller;

class HelpController extends AppController
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
