<?php

/** Repositorios del sistema */
namespace App\Repositories;

use App\Models\Parameter;

/**
 * @class ParameterRepository
 * @brief Gestiona los parámetros de configuración
 *
 * Gestiona los parámetros de configuración
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ParameterRepository
{
    /**
     * Actualiza o registra un parámetro de configuración
     *
     * @method    updateOrCreate
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     array            $parameterSearch    Listado con las opciones de consulta
     * @param     array            $parameterData      Listado con los datos a registrar o actualizar
     *
     * @return    Parameter        Objeto con la información del parámetro de configuración registrado
     */
    public function updateOrCreate($parameterSearch, $parameterData) : Parameter
    {
        return Parameter::updateOrCreate($parameterSearch, $parameterData);
    }
}
