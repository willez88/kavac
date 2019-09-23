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
                            'title' => 'Firmas personales y compañías anónimas',
                            'documents' => [
                                'Acta Constitutiva(Registro Mercantil) y sus Modificaciones. Publicación',
                                'Registro de Información Fiscal Actualizado',
                                'Cédula de Identidad del Representante Legal de La Empresa',
                                'Balance de Apertura para las Empresas Recientemente Constituidas',
                                'Balance General al Cierre del Ejercicio Económico Financiero Anterior, ' .
                                'al momento de presentar la documentación',
                                'Inscripción en el Registro Nacional de Contratista',
                                'Solvencia Laboral ante el IVSS'
                            ]
                        ],
                        [
                            'title' => 'Asociaciones cooperativas',
                            'documents' => [
                                'Acta Constitutiva y sus Modificaciones',
                                'RIF Actualizado',
                                'Certificado del Fiel Cumplimiento(SUNACOOP)',
                                'Balance de Apertura para Empresas Recientemente Constituidas',
                                'Balance General al Cierre del Ejercicio Económico Financiero Anterior',
                                'Cédula de Identidad de los Integrantes de la Junta Directiva de La Empresa',
                                'Inscripción en el Registro Nacional de Contratista',
                                'Solvencia del Seguro Social y Solvencia Laboral'
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
