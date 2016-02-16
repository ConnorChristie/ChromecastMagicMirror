<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CategoriesTable extends Table
{
    /**
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        $this->hasMany('Settings');
    }
}
