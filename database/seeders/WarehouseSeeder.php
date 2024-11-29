<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
   public function run()
   {
    //    // Warehouse dengan kapasitas 0%
       Warehouse::create([
           'name' => 'Warehouse Jakarta Pusat',
           'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
           'pole_capacity' => 1000,
           'cable_capacity' => 2000,
           'acc_capacity' => 5000,
           'used_pole_capacity' => 0,
           'used_cable_capacity' => 0, 
           'used_acc_capacity' => 0
       ]);

       // Warehouse dengan kapasitas sekitar 34%
       Warehouse::create([
           'name' => 'Warehouse Bandung',
           'address' => 'Jl. Asia Afrika No. 45, Bandung',
           'pole_capacity' => 1000,
           'cable_capacity' => 2000,
           'acc_capacity' => 5000,
           'used_pole_capacity' => 340, 
           'used_cable_capacity' => 680, 
           'used_acc_capacity' => 1700  
       ]);

   //     Warehouse::create([
   //      'name' => 'Warehouse Bandung',
   //      'address' => 'Jl. Asia Afrika No. 45, Bandung',
   //      'pole_capacity' => 1000,
   //      'cable_capacity' => 2000,
   //      'acc_capacity' => 5000,
   //      'used_pole_capacity' => 900, 
   //      'used_cable_capacity' => 1900, 
   //      'used_acc_capacity' => 4900  
   //  ]);
   }
}