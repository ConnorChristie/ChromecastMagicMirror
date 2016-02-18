<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    /**
     * Migration initialize
     *
     * @return void
     */
    public function up()
    {
        $table = $this->table('categories');
        $table
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('enabled', 'boolean', [
                'default' => 0,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('panel_width', 'integer', [
                'default' => 6,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('panel_row', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('panel_column', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->create();

        $table = $this->table('setting_values');
        $table
            ->addColumn('setting_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('value', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addIndex(
                [
                    'setting_id',
                ]
            )
            ->create();

        $table = $this->table('settings');
        $table
            ->addColumn('category_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('required', 'boolean', [
                'default' => 0,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('default_value', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('options', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'category_id',
                ]
            )
            ->create();

        $this->table('setting_values')
            ->addForeignKey(
                'setting_id',
                'settings',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('settings')
            ->addForeignKey(
                'category_id',
                'categories',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }

    /**
     * Migration revert
     *
     * @return void
     */
    public function down()
    {
        $this->table('setting_values')
            ->dropForeignKey(
                'setting_id'
            );

        $this->table('settings')
            ->dropForeignKey(
                'category_id'
            );

        $this->dropTable('categories');
        $this->dropTable('setting_values');
        $this->dropTable('settings');
    }
}
