<?php

namespace App\Controller\Component;

use App\Controller\AppController;
use Cake\Controller\Component;

class NavigationComponent extends Component
{
    private static $_items = [];

    /**
     * Adds the tabs to the page before it renders
     */
    public function beforeRender()
    {
        $controller = $this->_registry->getController();

        foreach (self::$_items as $key => $item)
        {
            self::$_items[$key]['active'] = $this->_isActive($item['title'], $controller);
        }

        $controller->set('navigation', ['tabs' => self::$_items]);
    }

    /**
     * Adds a tab to the navigation bar
     *
     * @param $title The title of the tab
     * @param $href The link of the tab
     */
    public static function addTab($title, $href)
    {
        array_push(self::$_items, ['title' => $title, 'href' => $href]);
    }

    /**
     * Checks if the tab is active
     *
     * @param $name The name of the tab to check
     * @param AppController $controller The current controller
     * @return bool If the specified tab is active
     */
    private function _isActive($name, AppController $controller)
    {
        return strtolower($name) == strtolower($controller->name);
    }
}
