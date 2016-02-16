<?php
namespace App\Seeds;

use Phinx\Seed\AbstractSeed;

/**
 * Settings seed.
 */
class SettingsSeed extends AbstractSeed
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
                'category_id' => 1
            ]
        ];

        $table = $this->table('settings');
        $table->insert($data)->save();
    }
}
