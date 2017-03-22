<?php

use Illuminate\Database\Seeder;

class CarInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $content = file_get_contents('/tmp/carInfo.json');
        $data = json_decode($content);
        DB::beginTransaction();
        try {
            foreach ($data as $brand) {
                $brand_id = DB::table('brands')->insertGetId([
                    'name' => $brand->name,
                    'code' => $brand->code,
                ]);
                $series = $brand->series;
                foreach ($series as $sery) {
                    $sery_id = DB::table('series')->insertGetId([
                        'name' => $sery->name,
                        'code' => $sery->code,
                        'brand_id' => $brand_id
                    ]);
                    $motomodels = $sery->styles;
                    foreach ($motomodels as $model) {
                        DB::table('motomodels')->insertGetId([
                            'name' => $model,
                            'code' => md5($model),
                            'sery_id' => $sery_id
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            echo 'error occured!';
            DB::rollBack();
        }

    }
}
