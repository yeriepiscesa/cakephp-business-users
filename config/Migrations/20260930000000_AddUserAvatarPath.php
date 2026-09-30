<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddUserAvatarPath extends BaseMigration
{
    public function change(): void
    {
        $this->table('users')
            ->addColumn('avatar_path', 'string', [
                'limit' => 64,
                'null' => true,
                'default' => null,
            ])
            ->update();
    }
}
