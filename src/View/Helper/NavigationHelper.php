<?php

namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;

class NavigationHelper extends HtmlHelper
{
    public function menu($navItems)
    {
        $items = [];

        foreach ($navItems as $navItem)
        {
            $activeCss = $navItem['active'] ? 'active' : '';

            $items += [sprintf('<a href="%s">%s</a>', $navItem['href'], $navItem['title']) => ['class' => $activeCss]];
        }

        return $this->nestedList($items, ['class' => 'nav navbar-nav']);
    }

    protected function _nestedListItem($items, $options, $itemOptions)
    {
        $out = '';

        $index = 1;
        foreach ($items as $key => $item) {
            $itemOptions = $item;

            if (is_array($item)) {
                $item = $key . $this->nestedList($item, $options, $itemOptions);
            }
            if (isset($itemOptions['even']) && $index % 2 === 0) {
                $itemOptions['class'] = $itemOptions['even'];
            } elseif (isset($itemOptions['odd']) && $index % 2 !== 0) {
                $itemOptions['class'] = $itemOptions['odd'];
            }
            $out .= $this->formatTemplate('li', [
                'attrs' => $this->templater()->formatAttributes($itemOptions, ['even', 'odd']),
                'content' => $key
            ]);
            $index++;
        }
        return $out;
    }
}