<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use App\Models\Institution;

if (! function_exists('set_active_menu')) {
    /**
     * Define la opción activa del menú según la URL actual
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param array|string $compareUrls Nombre o lista de nombres de las URL a comparar
     * @return string Si la URL a comparar es igual a la actual retorna active de lo contrario retorna vacio
     */
    function set_active_menu($compareUrls)
    {
        $currentUrl = Route::current()->getName();
        if (is_array($compareUrls)) {
            $active = '';
            foreach ($compareUrls as $url) {
                if ($currentUrl == $url) {
                    return 'active';
                }
            }
            return $active;
        }

        return ($currentUrl == $compareUrls) ? 'active' : '';
    }
}

if (! function_exists('display_submenu')) {
    /**
     * Define si se expande o contrae las opciones de un submenÚ
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string|array $submenu Nombre del submenu a mostrar u ocultar
     * @return string                Retorna una cadena vacia para contraer las opciones del submenú,
     *                               de lo contrario retorna el css para mostrar el bloque de opciones
     */
    function display_submenu($submenu)
    {
        if (is_array($submenu)) {
            foreach ($submenu as $sb) {
                if (strpos(Route::current()->getName(), $sb) !== false) {
                    return 'display:block';
                }
            }
        }
        return (!is_array($submenu) && strpos(Route::current()->getName(), $submenu) !== false) ? 'display:block;' : '';
    }
}

if (! function_exists('generate_registration_code')) {
    /**
     * Genera códigos a implementar en los diferentes registros del sistema
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string           $prefix      Prefijo que identifica el código
     * @param  integer          $code_length Longitud máxima permitida para el código a generar
     * @param  integer|string   $year        Sufijo que identifica el año del cual se va a generar el código
     * @param  string           $model       Namespace y nombre del modelo en donde se aplicará el nuevo código
     * @param  string           $field       Nombre del campo del código a generar
     * @return string|array                  Retorna una cadena con el nuevo código
     */
    function generate_registration_code($prefix, $code_length, $year, $model, $field)
    {
        $newCode = 1;

        $targetModel = $model::select($field)->where($field, 'like', "{$prefix}-%-{$year}")->withTrashed()
                             ->orderBy($field, 'desc')->first();

        $newCode += ($targetModel) ? (int)explode('-', $targetModel->$field)[1] : 0;

        if (strlen((string)$newCode) > $code_length) {
            return ["error" => "El nuevo código excede la longitud permitida"];
        }

        return "{$prefix}-{$newCode}-{$year}";
    }
}

if (!function_exists('template_choices')) {
    /**
     * Construye un arreglo de elementos para usar en plantillas blade
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string       $model     Nombre de la clase del modelo al cual generar el listado de opciones
     * @param  string|array $fields    Campo(s) a utilizar para mostrar en el listado de opciones
     * @param  array        $filters   Arreglo con los filtros a ser aplicados en la consulta
     *                                 Ej. sin relación con otro modelo: ['active' => 'true']
     *                                 Ej. con relación a otro modelo:
     *                                 ['relationship' => 'metodoRelacion', 'where' => ['active' => true]]
     * @param  boolean      $vuejs     Indica si las opciones a mostrar son para una plantilla
     *                                 normal o para VueJS
     * @param  integer      $except_id Identificador del registro a excluir. Opcional
     * @return array                   Arreglo con las opciones a mostrar
     */
    function template_choices($model, $fields = 'name', $filters = [], $vuejs = false, $except_id = null)
    {
        $records = $model::all();
        if ($filters) {
            if (!isset($filters['relationship'])) {
                $records = $model::where($filters)->get();
            } else {
                /** Filtra la información a obtener mediante relaciones */
                $relationship = $filters['relationship'];
                $records = $model::whereHas($relationship, function ($q) use ($filters) {
                    $q->where($filters['where']);
                })->get();
            }
        }

        /** Inicia la opción vacia por defecto */
        $options = ($vuejs) ? [['id' => '', 'text' => 'Seleccione...']] : ['' => 'Seleccione...'];

        foreach ($records as $rec) {
            if (is_array($fields)) {
                $text = '';
                foreach ($fields as $field) {
                    $text .= ($field !== "-" && $field !== " ")
                             ? $rec->$field
                             : (($field === " ") ? $field : " {$field} ");
                }
            } else {
                $text = $rec->$fields;
            }

            if (is_null($except_id) || $except_id !== $rec->id) {
                /**
                 * Carga el listado según el tipo de plantilla en el cual se va a implementar
                 * (normal o con VueJS)
                 */
                ($vuejs) ? array_push($options, ['id' => $rec->id, 'text' => $text])
                         : $options[$rec->id] = $text;
            }
        }
        return $options;
    }
}

if (!function_exists('validate_rif')) {
    /**
     * Verifica que el número de RIF sea correcto comproando el dígito verificador del mismo
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string $rif Cadena con el número de RIF completo
     * @return boolean     Devuelve verdadero si el número de RIF es correcto, de lo contrario devuelve falso
     */
    function validate_rif($rif)
    {
        $rifCheck = preg_match('/^([VEJPG]{1})([0-9]{8})([0-9]{1})$/', strtoupper($rif), $output_array);

        /** Si el número de RIF no es correcto retorna falso */
        if (!$rifCheck || !$output_array) {
            return false;
        }

        /** @var string Caracter que identifica el tipo de RIF (V, E, J, P, G) */
        $type = $output_array[1];
        /** @var string Número de RIF sin el tipo y el dígito verificador */
        $number = $output_array[2];
        /** @var string Caracter que representa el digito verificador del RIF */
        $digit = $output_array[3];

        /** @var array Arreglo cada número que compone los datos del RIF  sin el tipo y el dígito verificador */
        $validateNumber = str_split($number);
        $validateNumber[7] *= 2;
        $validateNumber[6] *= 3;
        $validateNumber[5] *= 4;
        $validateNumber[4] *= 5;
        $validateNumber[3] *= 6;
        $validateNumber[2] *= 7;
        $validateNumber[1] *= 2;
        $validateNumber[0] *= 3;

        /** Determinar dígito especial según la inicial del RIF (Regla introducida por el SENIAT) */
        switch ($type) {
            case 'V':
                $specialDigit = 1;
                break;
            case 'E':
                $specialDigit = 2;
                break;
            case 'J':
                $specialDigit = 3;
                break;
            case 'P':
                $specialDigit = 4;
                break;
            case 'G':
                $specialDigit = 5;
                break;
            default:
                $specialDigit = 0;
        }

        /** @var integer Sumatoria de los números del RIF y el dígito especial de validación */
        $sum = array_sum($validateNumber) + ($specialDigit * 4);
        /** @var integer Residuo obtenido entre la sumatoria de los números del rif y el dígito espcial de validación */
        $residue = $sum % 11;
        /** @var integer Resta obtenida del residuo */
        $subtraction = 11 - $residue;
        /**
         * @var integer Dato que permite identificar si el dígito verificador es correcto.
         *              0 = digito correcto, de lo contrario es incorrecto
         */
        $verifyDigit = ($subtraction >= 10) ? 0 : $subtraction;

        if ($verifyDigit != $digit) {
            /** Devuelve falso si el dígito verificador no es correcto */
            return false;
        }

        /** Retorna verdadero si el dígito verificador es correcto */
        return true;
    }
}

if (!function_exists('rif_exists')) {
    /**
     * Comprueba que un número de RIF exista
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string $rif Cadena con el número de RIF completo
     * @return boolean     Devuelve verdadero si el RIF existe, de lo contrario retorna falso
     */
    function rif_exists($rif)
    {
        // Comprobar si existe conexión externa para verificar la existencia del RIF
        // Conectar al organismo rector para verificar la existencia del RIF
        $connectionExists = check_connection();
        $rifExists = false;
        return ($connectionExists && $rifExists);
    }
}

if (!function_exists('validate_ci')) {
    /**
     * Verifica si un número de Cédula de Identidad es correcto
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string  $ci       Número de Cédula de Identidad
     * @param  boolean $with_nac Indica si la verificación del número de cédula es con la nacionalidad
     * @param  integer $length   Establece la longitud máxima del número de Cédula de Identidad
     * @return boolean           Devuelve verdadero si el número de cédula es correcto, de lo contrario devuelve falso
     */
    function validate_ci($ci, $with_nac = false, $length = 8)
    {
        $ciCheck = preg_match(
            ($with_nac) ? "/^([VE]{1})([0-9]{$length})$/" : "/^([0-9]{$length})$/",
            strtoupper($ci),
            $output_array
        );

        if (!$ciCheck || !$output_array) {
            return false;
        }

        // Establecer conexión con el organismo rector para determinar si la cédula existe

        return true;
    }
}

if (!function_exists('ci_exists')) {
    /**
     * Comprueba la existencia de un número de cédula de identidad
     * @param  string $ci  Número de cédula de identidad
     * @param  string $nac Indica la nacionalidad de la cédula a validar
     * @return boolean     Devuelve verdadero si el número de cédula existe, de lo contrario devuelve falso
     */
    function ci_exists($ci, $nac = 'V')
    {
        // Comprobar si existe conexión externa para verificar la existencia de la cédula
        // de identidad
        // Conectar al organismo rector para verificar la existencia de la cédula
        $connectionExists = check_connection();
        $exists = false;
        $personData = [];

        if ($connectionExists) {
            $client = new GuzzleHttp\Client();
            $res = $client->request(
                'GET',
                'www.cne.gob.ve/web/registro_civil/buscar_rep.php?nac=' . $nac . '&ced=' . $ci
            );

            if ($res->getStatusCode() === 200) {
                preg_match('/<b[^>]*>[^<]*<\/b>/', $res->getBody(), $content);
                if (count($content) > 0) {
                    // La cédula existe en el organismo rector
                    $oneName = strpos($content[0], '  ');
                    $oneLastName = strpos($content[0], ' </b>');
                    $filterContent = str_replace("  ", " ", trim($content[0]));
                    $filterContent = str_replace("<b>", "", trim($filterContent));
                    $filterContent = str_replace("</b>", "", trim($filterContent));
                    $data = explode(" ", $filterContent);
                    $personData = array_merge($personData, [
                        'firstName' => $data[0],
                        'secondName' => (!$oneName) ? $data[1] : '',
                        'firstLastName' => (!$oneName) ? $data[2] : $data[1],
                        'secondLastName' => (!$oneName)
                                            ? ((!$oneLastName) ? $data[3] : $data[2])
                                            : ((!$oneLastName) ? $data[2] : $data[1]),
                    ]);
                    $exists = true;
                }
            }
        }

        return compact('exists', 'connectionExists', 'personData');
    }
}

if (! function_exists('generate_code')) {
    /**
     * Genera una cadena aleatoria
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  object|string    $model  Clase del modelo a verificar
     * @param  string           $field  Nombre del campo a validar
     * @param  integer          $length Longitud máxima de la cadena a generar
     * @return string                   Devuelve una cadena aleatoria
     */
    function generate_code($model, $field, $length = 20)
    {
        $pool = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $code = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);

        $generatedCode = ($model::where($field, $code)->first())
                         ? $model::where($field, $code)->first()->$field : '';

        while ($generatedCode == $code) {
            $code = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
        }

        return $code;
    }
}

if (! function_exists('get_json_resource')) {
    /**
     * Obtiene el contenido de recursos json
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      string   $file   Nombre del archivo .json del cual se va a obtener su contenido
     *
     * @return     object   Objeto con elementos json
     */
    function get_json_resource($file, $module = null)
    {
        if (!is_null($module)) {
            return json_decode(
                file_get_contents(Module::getModulePath($module) . "/Resources/" . $file, true)
            );
        }

        return json_decode(
            file_get_contents(app()->resourcePath($file), true)
        );
    }
}

if (! function_exists('check_connection')) {
    /**
     * Determina si existe o no una conexión externa a Internet
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      string       $host    Dirección IP o URL del servidor al cual realizar la petición para identificar
     *                                   si existe la conexión
     * @param      integer      $port    Puerto de conexión al servidor
     *
     * @return     boolean               Devuelve verdadero si existe la conexión, de lo contrario retorna falso
     */
    function check_connection($host = 'www.google.com', $port = 80)
    {
        return (bool)@fsockopen($host, $port, $errno, $errstr, 4);
    }
}

if (! function_exists('get_institution')) {
    /**
     * Obtiene la informacion de una institución
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     *
     * @param  int|null $id [identificador unico de la institución]
     *
     * @return Institution     [informacion de la institución]
     */
    function get_institution($id = null)
    {
        if ($id) {
            return Institution::find($id);
        }
        return Institution::first();
    }
}

if (! function_exists('generate_hash')) {
    /**
     * Genera una cadena aleatoria
     *
     * @method     generate_hash
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      integer          $length          Longitud de la cadena a generar
     * @param      boolean          $specialChars    Condición que determina si se incluyen o no carácteres especiales
     *
     * @return     string           Devuelve una cadena aleatoria
     */
    function generate_hash($length = 8, $specialChars = false)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        $chars = '';

        if ($specialChars) {
            $chars = '%$[](-_)@/#{}';
            $alphabet .= $chars;
        }
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        $i = 0;
        while ($i < $length) {
            $n = rand(0, $alphaLength);
            if (in_array($alphabet[$n], $pass) && !empty($chars) && strpos($chars, $alphabet[$n])) {
                continue;
            }
            $pass[] = $alphabet[$n];
            $i++;
        }

        $hash = implode($pass);
        return $hash;
    }
}

if (! function_exists('execution_year')) {
    /**
     * Obtiene el año de ejecución del ejercicio económico
     *
     * @method     execution_year
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      string|hash   $year   Cadena con el año del ejercicio económico
     *
     * @return     string        Devuelve el año del ejercicio económico
     */
    function execution_year($year)
    {
        return (strlen($year) === 4) ? $year : Crypt::encrypt($year);
    }
}
