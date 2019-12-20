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

        factory(\App\Employee::class, 10)->create();
        factory(\App\User::class, 9)->create();
        DB::table('users')->insert($admin); // no delete
    }
}
