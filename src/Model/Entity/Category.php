<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Category extends Entity
{
    /**
     * Gets the category's panel width
     *
     * @param int $width The current width
     * @return int
     */
    protected function _getPanelWidth($width)
    {
        return isset($width) ? $width : 6;
    }
}
