<?php
namespace App\Controller;

use App\Controller\BaseController\APIController;

class FlashController extends APIController
{
    public $helpers = [
        'Flash' => [
            'className' => 'Bootstrap.BootstrapFlash'
        ]
    ];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Flash');
    }

    public function index()
    {
        $this->render('index', 'ajax');
    }
}
