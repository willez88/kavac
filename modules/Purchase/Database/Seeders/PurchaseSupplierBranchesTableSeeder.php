<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Models\PurchaseSupplierBranch;

class PurchaseSupplierBranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::transaction(function() {
            $supplierBranches = [
                ['name' => 'Fabricante'],
                ['name' => 'Distribuidor'],
                ['name' => 'Distribuidor Autorizado'],
                ['name' => 'Obras'],
                ['name' => 'Servicios y/o Servicios Autorizados'],
            ];

            foreach ($supplierBranches as $supBr) {
                PurchaseSupplierBranch::updateOrCreate($supBr, $supBr);
            }
        });
    }
}
