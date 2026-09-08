<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateCountries extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('countries');
        $table->addColumn('iso', 'string', [
            'default' => null,
            'limit' => 2,
            'null' => false,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('nicename', 'string', [
            'default' => null,
            'limit' => 150,
            'null' => false,
        ]);
        $table->addColumn('iso3', 'string', [
            'default' => null,
            'limit' => 3,
            'null' => true,
        ]);
        $table->addColumn('numcode', 'integer', [
            'default' => null,
            'limit' => 6,
            'null' => true,
        ]);
        $table->addColumn('phonecode', 'integer', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->create();
    }
}
