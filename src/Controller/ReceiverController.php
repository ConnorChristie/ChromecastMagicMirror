<?php
namespace App\Controller;

use App\Controller\BaseController\AppController;

class ReceiverController extends AppController
{
    /**
     * The main index for the receiver view
     *
     * @return void
     */
    public function index()
    {
        $this->renderModelView('index', null, 'receiver');
    }
}
