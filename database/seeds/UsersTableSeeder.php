<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
require_once __DIR__ . '/../../vendor/autoload.php';

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();
        DB::table('user_profiles')->truncate();
        DB::table('role_user')->truncate();

        Schema::enableForeignKeyConstraints();

        // init super admin
        User::create([
            'uid' => genId(),
            'username'   => 'admin',
            'email' => 'admin@keye.com',
            'mobile' => '11111',
            'password' => bcrypt(12345678),
            'status' => 1
        ]);

        $faker = Faker\Factory::create('zh_CN');
        $brands = $this->getBrands();
        $series = $this->getSeries();
        for ($i=0; $i<30; $i++) {
            $b = rand(0, count($brands)-1);
            $ss = $series[$b];
            $user = User::create([
                'uid' => genId(),
                'username'   => $faker->userName,
                'email' => $faker->email,
                'mobile' => $faker->phoneNumber,
                'password' => bcrypt(12345678),
                'status' => 1
            ]);
            UserProfile::create([
                'user_id' => $user->id,
                'real_name' => $faker->name,
                'id_no' => rand(1000000000, 9999999999).''.rand(100000000, 999999999),
                'member_no' => '',
                'keye_age' => rand(1, 10),
                'quotation' => $faker->sentence(6, true),
                'wechat_id' => $faker->uuid,
                'wechat_no' => $faker->userName,
                'sex' => rand(0, 1),
                'avatar' => $faker->imageUrl(50,50),
                'brand' => $brands[$b],
                'series' => $ss[rand(0, count($ss)-1)],
                'year' => rand(1900, 2017),
                'birth_place' => $faker->address,
                'birth_date' => $faker->date()
            ]);
            $user->roles()->attach([4,5,6][rand(0,2)]);
        }
    }

    public function getBrands() {
        return [
            '奥迪',
            '路虎',
            '宝马',
            '奔驰',
            '宾利',
            '悍马',
        ];
    }
    public function getSeries() {
        return [
            0 => ['奥迪Q3', '奥迪Q5', '奥迪Q7'],
            1 => ['揽胜', '揽胜运动版', '卫士'],
            2 => ['宝马X1', '宝马X3', '宝马X4', '宝马X5', '宝马X6'],
            3 => ['奔驰GLA级', '奔驰GLC级', '奔驰GLK级'],
            4 => ['添越'],
            5 => ['悍马H1', '悍马H2', '悍马H3'],
        ];
    }


}
