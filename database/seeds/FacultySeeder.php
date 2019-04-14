<?php

use App\User;
use App\Models\Faculty;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $faker->firstName($gender = 'male'|'female'),
                'middle_name' => $faker->lastName($gender = 'male'|'female'), 
                'last_name' => $faker->lastName($gender = 'male'|'female'),
                'name' => '',
                'email' => $faker->email,
                'password' => Hash::make('hello123'),
            ]);

            $student = Faculty::create([
                'user_id' => $user->id
            ]);

            $user->assignRole('faculty');

            $this->command->info('Faculty account created for ' . $user->fullname());
        }
    }
}
