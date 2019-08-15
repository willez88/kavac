<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Models\PurchaseSupplierSpecialty;

class PurchaseSupplierSpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $specialties = [
            ['name' => 'Agente de Aduanas'],
            ['name' => 'Agricultura'],
            ['name' => 'Agua Mineral'],
            ['name' => 'Artesanía'],
            ['name' => 'Artículos de Oficina'],
            ['name' => 'Auditoría Externa'],
            ['name' => 'Autorepuestos y Periquitos'],
            ['name' => 'Capacitación'],
            ['name' => 'Cerrajería'],
            ['name' => 'Comida y Refrijerios'],
            ['name' => 'Computación'],
            ['name' => 'Construcción'],
            ['name' => 'Constructora'],
            ['name' => 'Cristalería'],
            ['name' => 'Deportes'],
            ['name' => 'Diseño y Tecnología'],
            ['name' => 'Electricidad'],
            ['name' => 'Electrónica'],
            ['name' => 'Empresa de Seguro'],
            ['name' => 'Empresas Radiodifusoras'],
            ['name' => 'Encomiendas'],
            ['name' => 'Equipos de Laboratorio'],
            ['name' => 'Escritorio Jurídico'],
            ['name' => 'Farmacia'],
            ['name' => 'Ferretería'],
            ['name' => 'Festejos'],
            ['name' => 'Floristería'],
            ['name' => 'Fotocopia y Reproducción'],
            ['name' => 'Fotografía'],
            ['name' => 'Fumigaciones'],
            ['name' => 'Gestión de agua potable y saneamiento'],
            ['name' => 'Gobierno Nacional'],
            ['name' => 'Gobierno Regional'],
            ['name' => 'Herrería'],
            ['name' => 'Hoteles y Posadas'],
            ['name' => 'Laboratorio Fotográfico'],
            ['name' => 'Librería'],
            ['name' => 'Limpieza'],
            ['name' => 'Litografía y Tipografía'],
            ['name' => 'Mantenimiento de áreas verdes'],
            ['name' => 'Mantenimiento de equipos'],
            ['name' => 'Mantenimiento y limpieza en general'],
            ['name' => 'Materiales de construcción'],
            ['name' => 'Medicamentos'],
            ['name' => 'Mobiliario de equipos de oficina'],
            ['name' => 'Motos y accesorios'],
            ['name' => 'Música'],
            ['name' => 'Persianas verticales'],
            ['name' => 'Pinturas'],
            ['name' => 'Plomeros'],
            ['name' => 'Proveeduría'],
            ['name' => 'Publicidad'],
            ['name' => 'Refrigeración'],
            ['name' => 'Restaurante'],
            ['name' => 'Servicio de auditoría'],
            ['name' => 'Servicio de Cesta Ticket'],
            ['name' => 'Servicio de Guardería'],
            ['name' => 'Servicio de manejo y control de almacén'],
            ['name' => 'Servicios'],
            ['name' => 'Servicios Públicos'],
            ['name' => 'Sonido'],
            ['name' => 'Supermercado'],
            ['name' => 'Tabiquería y cielo razo'],
            ['name' => 'Taller Mecánico'],
            ['name' => 'Telecomunicaciones'],
            ['name' => 'Transporte'],
            ['name' => 'Uniformes'],
            ['name' => 'Variedad'],
            ['name' => 'Viajes y Turismo'],
            ['name' => 'Vídeo y Televisión'],
            ['name' => 'Vidrios'],
            ['name' => 'Vigilancia'],
            ['name' => 'Viveros'],
        ];

        DB::transaction(function () use ($specialties) {
            foreach ($specialties as $specialty) {
                PurchaseSupplierSpecialty::updateOrCreate($specialty, $specialty);
            }
        });
    }
}
