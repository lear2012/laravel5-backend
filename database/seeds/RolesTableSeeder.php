<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();
        $roleArr = array(
            array('name' => 'admin', 'display_name' => '管理员', 'description' => '超级管理员'),
            array('name' => 'register_member', 'display_name' => '注册会员', 'description' => '注册会员'),
            array('name' => 'paid_member', 'display_name' => '付费会员', 'description' => '付费会员'),
            array('name' => 'exp_driver', 'display_name' => '老司机', 'description' => '老司机'),
        );

        foreach ($roleArr as $role) {
            $role = \App\Models\Role::create([
                'name'   => $role['name'],
                'display_name' => $role['display_name'],
                'description' => 'description',
            ]);

            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$role->id, 1]);
        }

    }
}
