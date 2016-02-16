<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SettingValuesTable extends Table
{
    /**
     * @param array $config The config
     * @return void
     */
    public function initialize(array $config)
    {
        $this->belongsTo('Settings');
    }
}
