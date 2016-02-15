<?php

namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;

class NavigationHelper extends HtmlHelper
{
    /**
     * Generates a HTML menu from the array of nav items
     *
     * @param $navItems An array of nav items
     * @return string The navbar menu items as HTML
     */
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

    /**
     * Internal function to build a nested list (UL/OL) out of an associative array.
     *
     * @param array $items Set of elements to list.
     * @param array $options Additional HTML attributes of the list (ol/ul) tag.
     * @param array $itemOptions Options and additional HTML attributes of the list item (LI) tag.
     * @return string The nested list element
     * @see HtmlHelper::nestedList()
     */
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
