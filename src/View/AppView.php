<?php
namespace App\View;

use Cake\View\View;

class AppView extends View
{
    /**
     * Initializes the view with a navigation helper
     */
    public function initialize()
    {
        $this->loadHelper('Navigation');

        parent::initialize();
    }
}
