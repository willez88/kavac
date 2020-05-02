<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Models\PurchaseTypeOperation;

class PurchaseTypeOperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Model::unguard();

        DB::transaction(function () {
            $types = [
                ['name' => 'Bienes'],
                ['name' => 'Obras'],
                ['name' => 'Servicios'],
            ];

            foreach ($types as $type) {
                PurchaseTypeOperation::updateOrCreate($type, $type);
            }
        });*/
    }
}
