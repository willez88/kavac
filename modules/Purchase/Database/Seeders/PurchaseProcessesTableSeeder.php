<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Models\PurchaseProcess;
use App\Models\Parameter;

class PurchaseProcessesTableSeeder extends Seeder
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
            Parameter::updateOrCreate(
                [
                    'p_key' => 'process_documents',
                    'required_by' => 'purchase',
                    'active' => true
                ],
                [
                    'p_value' => json_encode([
                        [
                            'id' => '1',
                            'title' => 'Firmas personales y compañías anónimas',
                            'documents' => [
                                '1' => 'Acta Constitutiva(Registro Mercantil) y sus Modificaciones. Publicación',
                                '2' => 'Registro de Información Fiscal Actualizado',
                                '3' => 'Cédula de Identidad del Representante Legal de La Empresa',
                                '4' => 'Balance de Apertura para las Empresas Recientemente Constituidas',
                                '5' => 'Balance General al Cierre del Ejercicio Económico Financiero Anterior, ' .
                                       'al momento de presentar la documentación',
                                '6' => 'Inscripción en el Registro Nacional de Contratista',
                                '7' => 'Solvencia Laboral ante el IVSS'
                            ]
                        ],
                        [
                            'id' => '2',
                            'title' => 'Asociaciones cooperativas',
                            'documents' => [
                                '1' => 'Acta Constitutiva y sus Modificaciones',
                                '2' => 'RIF Actualizado',
                                '3' => 'Certificado del Fiel Cumplimiento(SUNACOOP)',
                                '4' => 'Balance de Apertura para Empresas Recientemente Constituidas',
                                '5' => 'Balance General al Cierre del Ejercicio Económico Financiero Anterior',
                                '6' => 'Cédula de Identidad de los Integrantes de la Junta Directiva de La Empresa',
                                '7' => 'Inscripción en el Registro Nacional de Contratista',
                                '8' => 'Solvencia del Seguro Social y Solvencia Laboral'
                            ]
                        ]
                    ])
                ]
            );


            $processes = [
                [
                    'name' => 'Orden de Compra',
                    'description' => 'Proceso para las órdenes de compra'
                ],
                [
                    'name' => 'Orden de Servicio',
                    'description' => 'Proceso para las órdenes de servicio'
                ],
                [
                    'name' => 'Disponibilidad Presupuestaria',
                    'description' => 'Proceso para las disponibilidades presupuestarias'
                ],
                [
                    'name' => 'Cotización', 'description' => 'Proceso para las cotizaciones'
                ]
            ];

            foreach ($processes as $process) {
                PurchaseProcess::updateOrCreate(
                    ['name' => $process['name']],
                    ['description' => $process['description']]
                );
            }
        });
    }
}
