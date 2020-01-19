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
        $user_roles = require_once 'data-set/UserRole.php';
        $academic_degree = require_once 'data-set/AcademicDegree.php';
        $posts = require_once 'data-set/Posts.php';
        $facultes = require_once 'data-set/Facultes.php';
        $departaments = require_once 'data-set/Departaments.php';

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
