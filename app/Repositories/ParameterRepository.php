<?php

/** Repositorios del sistema */
namespace App\Repositories;

use App\Models\Parameter;

class ParameterRepository
{
    public function updateOrCreate($parameterSearch, $parameterData) : Parameter
    {
        return Parameter::updateOrCreate($parameterSearch, $parameterData);
    }
}
