<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Category extends Entity
{
    protected function _getPanelWidth($width)
    {
        return isset($width) ? $width : 6;
    }
}
