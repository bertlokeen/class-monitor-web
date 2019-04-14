<?php

use App\User;
use App\Models\Student;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = ['BSIT', 'BSCS', 'BSIS', 'BSCE'];
        $years = [4, 3, 2, 1];
        $sections = [4, 3, 2, 1];

        $faker = Faker::create();

        for ($i = 0; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $faker->firstName($gender = 'male'|'female'),
                'middle_name' =>  $faker->lastName($gender = 'male'|'female'), 
                'last_name' => $faker->lastName($gender = 'male'|'female'),
                'name' => '',
                'email' => $faker->email,
                'password' => Hash::make('hello123'),
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'course' => $courses[array_rand($courses)],
                'year' => $years[array_rand($years)],
                'section' => $sections[array_rand($sections)]
            ]);

            $user->assignRole('student');

            $this->command->info('Student account created for ' . $user->fullname());
        }
    }
}
