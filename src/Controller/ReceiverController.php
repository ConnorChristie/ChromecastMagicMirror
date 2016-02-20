<?php
namespace App\Controller;

use App\Controller\BaseController\AppController;

class ReceiverController extends AppController
{
    public function index()
    {
        $this->renderModelView('index', null, 'receiver');
    }
}
