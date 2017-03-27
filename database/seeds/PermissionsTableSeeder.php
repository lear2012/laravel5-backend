<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissionArr = array(
            array('name' => 'decorate_home', 'display_name' => '装饰老司机个人页面'),
        );

        foreach ($permissionArr as $perm) {
            $permission = \App\Models\Permission::create([
                'name'   => $perm['name'],
                'display_name' => $perm['display_name'],
                'description' => '',
            ]);

            DB::insert('insert into permission_role (permission_id, role_id) values (?, ?)', [$permission->id, 1]);
        }
    }
}
