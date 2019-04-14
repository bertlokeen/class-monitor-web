<?php

use App\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Initial',
            'last_name' => 'Admin',
            'name' => 'Initial Admin',
            'email' => 'initial.admin@classmonitor.com',
            'password' => Hash::make('admin123'),
        ]);

        $admin = Admin::create([
            'user_id' => $user->id
        ]);
        
        $user->assignRole('admin');

        $this->command->info('Created admin account for ' . $user->fullname() . ', login with: ' . $user->email . ' & admin123');
    }
}
