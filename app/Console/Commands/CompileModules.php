<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Module;

class CompileModules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:compile
                            {module? : The module name to compile}
                            {--p|prod : Option to compile in production mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'compile assets modules';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("== Iniciando compilación de módulos ==");

        /** @var string Guarda el listado d elos módulos compilados */
        $m = '';
        /** @var string Modo de compilación. dev = desarrollo, prod = producción */
        $compileMode = ($this->option('prod'))?'prod':'dev';
        /** @var boolean Determina si se encuentra un error en la compilación */
        $hasError = false;
        /** @var string Mensaje del error */
        $errorMsg = '';
        /** @var string Nombre del módulo que generó error al compilar */
        $errorModule = '';

        foreach (Module::collections(1) as $module) {
            if ($this->argument('module') && strtolower($this->argument('module')) !== strtolower($module)) {
                continue;
            }
            $this->info("Compilando módulo: " . $module->getName());
            $result = shell_exec("cd modules/$module && npm run $compileMode");
            if (strpos($result, 'successfully') === false) {
                $hasError = true;
                $errorMsg = $result;
                $errorModule = $module;
                break;
            }
            $m .= "$module,";
            echo $result;
        }

        if (!empty($m)) {
            $this->info("Se han compilado los módulos [".trim($m, ',')."]");
        }
        if ($hasError) {
            $this->info("Ocurrió un error en la compilación del módulo $errorModule");
            $this->info("Detalles del error:");
            $this->info($errorMsg);
        }
        return 0;
    }
}
