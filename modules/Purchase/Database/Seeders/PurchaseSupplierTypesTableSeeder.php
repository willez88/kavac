<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Models\PurchaseSupplierType;

class PurchaseSupplierTypesTableSeeder extends Seeder
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
            $types = [
                ['name' => 'Firma Personal'],
                ['name' => 'Compañía Anónima (C.A.)'],
                ['name' => 'Sociedad Anónima (S.A.)'],
                ['name' => 'Cooperativa'],
                ['name' => 'Comanditas'],
                ['name' => 'Sociedad de Responsabilidad Limitada (S.R.L.)'],
                ['name' => 'Asociaciones Civiles'],
                ['name' => 'Fundaciones'],
                ['name' => 'Organizaciones Socio-Productivas'],
                ['name' => 'Otra forma asociativa']
            ];

            foreach ($types as $type) {
                PurchaseSupplierType::updateOrCreate($type, $type);
            }
        });
    }
}
