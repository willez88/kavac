<?php
/** Gestiona los comandos personalizados de la aplicación */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Module;

/**
 * @class CompileModules
 * @brief Gestiona las instrucciones necesarias para ejecutar los comandos para la compilación de archivos
 *
 * Gestiona las instrucciones para la compilación de archivos css y js
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class CompileModules extends Command
{
    /**
     * El combre y firma del comando, así como las opciones y argumentos que recibe
     *
     * @var string
     */
    protected $signature = 'module:compile
                            {module? : The module name to compile}
                            {--p|prod : Option to compile in production mode}
                            {--i|install : With previous install node packages}
                            {--s|system : With core compile}';

    /**
     * Descripción del comando.
     *
     * @var string
     */
    protected $description = 'compile assets modules';

    /**
     * Crea una nueva instancia al comando.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ejecuta el comando de la consola.
     *
     * @return int
     */
    public function handle()
    {
        $withCore = ($this->option('system'))?true:false;

        $this->line('');
        $this->line('<fg=yellow>---------------------------------------------------------</>');
        $this->line('<fg=yellow>|                Compilación de archivos                |</>');
        $this->line('<fg=yellow>---------------------------------------------------------</>');
        $this->line('');

        /** @var string Guarda el listado d elos módulos compilados */
        $m = [];
        /** @var string Modo de compilación. dev = desarrollo, prod = producción */
        $compileMode = ($this->option('prod'))?'prod':'dev';

        $withInstall = ($this->option('install'))?'&& npm install':'';
        /** @var boolean Determina si se encuentra un error en la compilación */
        $hasError = false;
        /** @var string Mensaje del error */
        $errorMsg = '';
        /** @var string Nombre del módulo que generó error al compilar */
        $errorModule = '';

        /** @var object Objeto con información de los módulos habilitados en la aplicación */
        $modules = Module::collections(1);
        /** @var integer Total de módulos habilitados */
        $count = (!$this->argument('module'))?count($modules):1;
        /** @var integer contador que registra el número de modulo que se compila */
        $index = 1;

        if ($withCore) {
            $this->line('');
            $this->line("<fg=green>Compilando archivos del sistema</>");
            if (!empty($withInstall)) {
                $result = shell_exec("npm install");
                if (strpos($result, 'successfully') === false) {
                    $hasError = true;
                    $errorMsg = $result;
                    $this->info("Ocurrió un error en la compilación");
                    $this->info("Detalles del error:");
                    $this->info($errorMsg);
                    return 0;
                }
            }
            $result = shell_exec("npm run $compileMode");
            if (strpos($result, 'successfully') === false) {
                $hasError = true;
                $errorMsg = $result;
                $this->info("Ocurrió un error en la compilación");
                $this->info("Detalles del error:");
                $this->info($errorMsg);
                return 0;
            }
        }

        foreach ($modules as $key => $module) {
            if ($this->argument('module') && strtolower($this->argument('module')) !== strtolower($module)) {
                continue;
            }
            $this->line('');
            $this->line("<fg=green>Compilando módulo $index/$count:</> <fg=yellow>" . $module->getName()) . "</>";
            $result = shell_exec("cd modules/$module $withInstall && npm run $compileMode");
            if (strpos($result, 'successfully') === false) {
                $hasError = true;
                $errorMsg = $result;
                $errorModule = $module;
                break;
            }
            array_push($m, $module);
            echo $result;
            $index++;
        }

        if (!empty($m) && !$hasError) {
            if ($withCore) {
                $this->line("");
                $this->info("Se ha compilado los archivos de la aplicación");
            }
            $this->line("");
            $this->info("Se han compilado los siguientes módulos:");
            $this->line("");
            foreach ($m as $compiledModule) {
                $this->line("<fg=yellow>- $compiledModule</>");
            }
            $this->line("");
        }
        if ($hasError) {
            $this->info("Ocurrió un error en la compilación del módulo $errorModule");
            $this->info("Detalles del error:");
            $this->info($errorMsg);
        }
        return 0;
    }
}
