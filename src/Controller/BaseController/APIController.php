<?php
namespace App\Controller\BaseController;

use Cake\Controller\Controller;

class APIController extends Controller
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadComponent('RequestHandler');
    }
}
