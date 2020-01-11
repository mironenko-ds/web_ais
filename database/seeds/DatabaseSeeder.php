<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user_roles = [
            [ 'role_name' => 'user' ],
            [ 'role_name' => 'moderator' ],
            [ 'role_name' => 'admin' ]
        ];

        $academic_degree = [
            [ 'degree_name' => 'Кандидат наук' ],
            [ 'degree_name' => 'Доктор наук' ]
        ];

        $posts = [
            [ 'post_name' => 'Преподаватель' ],
            [ 'post_name' => 'Старший преподаватель' ],
            [ 'post_name' => 'Доцент' ],
            [ 'post_name' => 'Профессор' ],
            [ 'post_name' => 'Декан' ],
            [ 'post_name' => 'Проректор' ],
            [ 'post_name' => 'Ректор' ]
        ];

        $facultes = [
            [ 'faculty_name' => 'Металлургический факультет', 'head_faculty' => '12123'],
            [ 'faculty_name' => 'Социально-гуманитарный факультет', 'head_faculty' => '12123'],
            [ 'faculty_name' => 'Факультет инженерной и языковой подготовки', 'head_faculty' => '12123'],
            [ 'faculty_name' => 'Факультет информационных технологий', 'head_faculty' => '12123'],
            [ 'faculty_name' => ' Факультет машиностроения и сварки', 'head_faculty' => '12123'],
            [ 'faculty_name' => 'Факультет транспортных технологий', 'head_faculty' => '12123'],
            [ 'faculty_name' => 'Экономический факультет', 'head_faculty' => '12123'],
            [ 'faculty_name' => 'Энергетический факультет', 'head_faculty' => '12123']
        ];

        $departaments = [
            ['departament_name' => '43ек344', 'faculty_id' => '1', 'head_departament' => 'рпа'],
            ['departament_name' => '43345ек4', 'faculty_id' => '2', 'head_departament' => 'fddпаf'],
            ['departament_name' => '43347н4', 'faculty_id' => '3', 'head_departament' => 'fddf45ку'],
            ['departament_name' => '433не44', 'faculty_id' => '4', 'head_departament' => 'fddнеf'],
            ['departament_name' => '4336е44', 'faculty_id' => '5', 'head_departament' => 'fdd5кf'],
            ['departament_name' => '4336е44', 'faculty_id' => '6', 'head_departament' => 'fdd6еf'],
            ['departament_name' => '4334к44', 'faculty_id' => '7', 'head_departament' => 'fdd6нf'],
            ['departament_name' => '4334544', 'faculty_id' => '8', 'head_departament' => 'fdd6нf']
        ];

        //create admin

        $admin = [
            [ 'role_id' => 3,
                'password' => Hash::make('sasha123'),
                'employee_id' => 10,
                'email' => 'admin@admin.com' ]
        ];


        DB::table('user_roles')->insert($user_roles); // no delete
        DB::table('academic_degrees')->insert($academic_degree); // no delete
        DB::table('posts')->insert($posts); // no delete
        DB::table('facultes')->insert($facultes); // no delete
        DB::table('departments')->insert($departaments); // no delete


        factory(\App\Employee::class, 10)->create();
        factory(\App\User::class, 9)->create();
        DB::table('users')->insert($admin); // no delete
    }
}
