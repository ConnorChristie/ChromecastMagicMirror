<?php

namespace App\Controller\Component;

use App\Controller\AppController;
use Cake\Controller\Component;

class NavigationComponent extends Component
{
    private static $_items = [];

    public function beforeRender()
    {
        $controller = $this->_registry->getController();

        foreach (self::$_items as $key => $item)
        {
            self::$_items[$key]['active'] = $this->isActive($item['title'], $controller);
        }

        $controller->set('navigation', ['tabs' => self::$_items]);
    }

    public static function addTab($title, $href)
    {
        array_push(self::$_items, ['title' => $title, 'href' => $href]);
    }

    private function isActive($name, AppController $controller)
    {
        return strtolower($name) == strtolower($controller->name);
    }
}