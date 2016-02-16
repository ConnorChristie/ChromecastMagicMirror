<?php
use Phinx\Seed\AbstractSeed;

/**
 * Categories seed.
 */
class CategoriesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Magic Mirror Settings',
                'panel_width' => 6
            ],
            [
                'name' => 'Weather Settings',
                'panel_width' => 6
            ]
        ];

        $table = $this->table('categories');
        $table->insert($data)->save();
    }
}
