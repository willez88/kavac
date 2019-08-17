<?php

namespace Modules\Finance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Finance\Models\FinanceBank;

class FinanceBanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $finance_banks = [
            [
                'code' => '0001',
                'short_name' => 'BCV',
                'name' => 'BANCO CENTRAL DE VENEZUELA',
                'website' => 'www.bcv.org.ve'
            ],
            [
                'code' => '0003',
                'short_name' => 'BIV',
                'name' => 'BANCO INDUSTRIAL DE VENEZUELA, C.A. BANCO UNIVERSAL',
                'website' => null
            ],
            [
                'code' => '0102',
                'short_name' => 'BDV',
                'name' => 'BANCO DE VENEZUELA S.A.C.A. BANCO UNIVERSAL',
                'website' => 'www.bancodevenezuela.com'
            ],
            [
                'code' => '0104',
                'short_name' => 'BVC',
                'name' => 'VENEZOLANO DE CRÉDITO, S.A. BANCO UNIVERSAL',
                'website' => 'www.venezolano.com'
            ],
            [
                'code' => '0105',
                'short_name' => 'MERCANTIL',
                'name' => 'BANCO MERCANTIL, C.A. S.A.C.A. BANCO UNIVERSAL',
                'website' => 'www.mercantilbanco.com'
            ],
            [
                'code' => '0108',
                'short_name' => 'BBVA',
                'name' => 'BANCO PROVINCIAL, S.A. BANCO UNIVERSAL',
                'website' => 'www.provincial.com'
            ],
            [
                'code' => '0114',
                'short_name' => 'BANCARIBE',
                'name' => 'BANCARIBE C.A. BANCO UNIVERSAL',
                'website' => 'www.bancaribe.com.ve'
            ],
            [
                'code' => '0115',
                'short_name' => 'EXTERIOR',
                'name' => 'BANCO EXTERIOR C.A. BANCO UNIVERSAL',
                'website' => 'www.bancoexterior.com'
            ],
            [
                'code' => '0116',
                'short_name' => 'BOD',
                'name' => 'BANCO OCCIDENTAL DE DESCUENTO, BANCO UNIVERSAL C.A.',
                'website' => 'www.bod.com.ve'
            ],
            [
                'code' => '0128',
                'short_name' => 'CARONI',
                'name' => 'BANCO CARONÍ C.A., BANCO UNIVERSAL',
                'website' => 'www.bancocaroni.com.ve'
            ],
            [
                'code' => '0134',
                'short_name' => 'BANESCO',
                'name' => 'BANESCO BANCO UNIVERSAL S.A.C.A.',
                'website' => 'www.banesco.com'
            ],
            [
                'code' => '0137',
                'short_name' => 'SOFITASA',
                'name' => 'BANCO SOFITASA BANCO UNIVERSAL',
                'website' => 'www.sofitasa.com'
            ],
            [
                'code' => '0138',
                'short_name' => 'PLAZA',
                'name' => 'BANCO PLAZA BANCO UNIVERSAL',
                'website' => 'www.bancoplaza.com'
            ],
            [
                'code' => '0146',
                'short_name' => 'BANGENTE',
                'name' => 'BANCO DE LA GENTE EMPRENDEDORA C.A.',
                'website' => 'www.bangente.com.ve'
            ],
            [
                'code' => '0149',
                'short_name' => '',
                'name' => 'BANCO DEL PUEBLO SOBERANO, C.A. BANCO DE DESARROLLO',
                'website' => null
            ],
            [
                'code' => '0151',
                'short_name' => 'BFC',
                'name' => 'BANCO FONDO COMÚN C.A. BANCO UNIVERSAL',
                'website' => 'www.bfc.com.ve'
            ],
            [
                'code' => '0156',
                'short_name' => '100%',
                'name' => '100% BANCO, BANCO UNIVERSAL C.A.',
                'website' => 'www.100x100banco.com'
            ],
            [
                'code' => '0157',
                'short_name' => 'DELSUR',
                'name' => 'DELSUR BANCO UNIVERSAL, C.A.',
                'website' => 'www.delsur.com.ve'
            ],
            [
                'code' => '0163',
                'short_name' => 'TESORO',
                'name' => 'BANCO DEL TESORO, C.A. BANCO UNIVERSAL',
                'website' => 'www.bt.gob.ve'
            ],
            [
                'code' => '0166',
                'short_name' => 'BAV',
                'name' => 'BANCO AGRÍCOLA DE VENEZUELA, C.A. BANCO UNIVERSAL',
                'website' => 'www.bav.com.ve'
            ],
            [
                'code' => '0168',
                'short_name' => 'BANCRECER',
                'name' => 'BANCRECER, S.A. BANCO MICROFINANCIERO',
                'website' => 'www.bancrecer.com.ve'
            ],
            [
                'code' => '0169',
                'short_name' => 'MI BANCO',
                'name' => 'MI BANCO BANCO MICROFINANCIERO C.A.',
                'website' => 'www.mibanco.com.ve'
            ],
            [
                'code' => '0171',
                'short_name' => 'ACTIVO',
                'name' => 'BANCO ACTIVO, C.A. BANCO UNIVERSAL',
                'website' => 'www.bancoactivo.com'
            ],
            [
                'code' => '0172',
                'short_name' => 'BANCAMIGA',
                'name' => 'BANCAMIGA BANCO MICROFINANCIERO C.A.',
                'website' => 'www.bancamiga.com'
            ],
            [
                'code' => '0173',
                'short_name' => 'BID',
                'name' => 'BANCO INTERNACIONAL DE DESARROLLO, C.A. BANCO UNIVERSAL',
                'website' => 'www.bid.com.ve'
            ],
            [
                'code' => '0174',
                'short_name' => 'BANPLUS',
                'name' => 'BANPLUS BANCO UNIVERSAL, C.A.',
                'website' => 'www.banplus.com'
            ],
            [
                'code' => '0175',
                'short_name' => 'BICENTENARIO',
                'name' => 'BANCO BICENTENARIO BANCO UNIVERSAL C.A.',
                'website' => 'www.bicentenariobu.com'
            ],
            [
                'code' => '0177',
                'short_name' => 'BANFANB',
                'name' => 'BANCO DE LA FUERZA ARMADA NACIONAL BOLIVARIANA, B.U.',
                'website' => 'www.banfanb.com.ve'
            ],
            [
                'code' => '0190',
                'short_name' => 'CITI',
                'name' => 'CITIBANK',
                'website' => 'www.citibank.com.ve'
            ],
            [
                'code' => '0191',
                'short_name' => 'BNC',
                'name' => 'BANCO NACIONAL DE CRÉDITO, C.A. BANCO UNIVERSAL',
                'website' => 'www.bnc.com.ve'
            ]
        ];

        DB::transaction(function () use ($finance_banks) {
            foreach ($finance_banks as $bank) {
                FinanceBank::updateOrCreate(
                    ['code' => $bank['code']],
                    [
                        'short_name' => $bank['short_name'],
                        'name' => $bank['name'],
                        'website' => $bank['website']
                    ]
                );
            }
        });
    }
}
