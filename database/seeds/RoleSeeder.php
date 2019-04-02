<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'faculty',
            'student'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
            $this->command->info('Creating role for ' . $role);
        }
    }
}
