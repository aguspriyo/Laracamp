<?php

namespace Database\Seeders;

use App\Models\Camps;
use Illuminate\Database\Seeder;

class CampTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $camps = [
      [
        'title' => 'Gila Belajar',
        'slug' => 'gila-belajar',
        'price' => 200,
        'created_at' => date('Y-n-d H:i:s', time()),
        'updated_at' => date('Y-n-d H:i:s', time()),
      ],
      [
        'title' => 'Baru Mulai',
        'slug' => 'baru-mulai',
        'price' => 140,
        'created_at' => date('Y-n-d H:i:s', time()),
        'updated_at' => date('Y-n-d H:i:s', time()),
      ],
    ];
    //1st method
    foreach ($camps as $key => $camp) {
      Camps::create($camp);
    }

    //2nd method
    //Camps::insert($camp);
  }
}