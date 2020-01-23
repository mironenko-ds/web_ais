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

        $type_work = require_once 'data-set/TypeWork.php';
        $works_kinds = require_once 'data-set/WorkKinds.php';
        $works = require_once 'data-set/Works.php';

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


        factory(\App\Models\Employee::class, 10)->create();
        factory(\App\Models\User::class, 9)->create();
        DB::table('users')->insert($admin); // no delete

        DB::table('type-works')->insert($type_work);
        DB::table('works_kinds')->insert($works_kinds);
        DB::table('works')->insert([$works[0]]);
        //DB::table('works')->insert($works[1]);
        //DB::table('works')->insert($works[2]);
    }
}
