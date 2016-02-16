<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CategoriesTable extends Table
{
    /**
     * @param array $config The config
     * @return void
     */
    public function initialize(array $config)
    {
        $this->hasMany('Settings');
    }
}
