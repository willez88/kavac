<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Models\PurchaseSupplierObject;

class PurchaseSupplierObjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::transaction(function () {
            $supplierObjects = [
                ['type' => 'B', 'name' => 'Productos'],
                ['type' => 'B', 'name' => 'Materiales'],
                ['type' => 'B', 'name' => 'Maquinarias'],
                ['type' => 'B', 'name' => 'Equipos'],
                ['type' => 'B', 'name' => 'Muebles'],
                ['type' => 'O', 'name' => 'Mano de Obra'],
                ['type' => 'S', 'name' => 'Mano de Obra'],
            ];

            foreach ($supplierObjects as $supObj) {
                PurchaseSupplierObject::updateOrCreate($supObj, $supObj);
            }
        });
    }
}
