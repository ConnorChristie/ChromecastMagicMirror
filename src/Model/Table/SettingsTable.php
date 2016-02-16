<?php
namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\Table;

class SettingsTable extends Table
{
    /**
     * @param array $config The config
     * @return void
     */
    public function initialize(array $config)
    {
        $this->hasOne('SettingValues');
        $this->belongsTo('Categories');
    }

    /**
     * Creates a settings table
     *
     * @param string $name The table name
     * @return void
     */
    public static function createSettingsTable($name)
    {
        $t = new \Cake\Database\Schema\Table($name . '_settings');

        $t->addColumn('id', 'integer');
        $t->addColumn('category_id', 'integer');
        $t->addColumn('name', 'string');
        $t->addColumn('required', [
            'type' => 'boolean',
            'default' => 0
        ]);
        $t->addColumn('default_value', 'string');
        $t->addColumn('options', 'text');

        $t->addConstraint('primary', [
            'type' => 'primary',
            'columns' => ['id']
        ]);

        $t->addIndex('category_id', [
            'columns' => ['category_id'],
            'type' => 'index'
        ]);

        $t->addConstraint('fk_' . $name . '_settings_categories_category_id', [
            'columns' => ['category_id'],
            'type' => 'foreign',
            'references' => ['categories', 'id'],
            'update' => 'cascade',
            'delete' => 'cascade'
        ]);

        $db = ConnectionManager::get('default');

        $queries = $t->createSql($db);
        foreach ($queries as $sql) {
            $db->execute($sql);
        }
    }
}
