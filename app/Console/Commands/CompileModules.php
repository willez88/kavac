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
                            {--p|prod : Option to compile in production mode}
                            {--i|install : With previous install node packages}
                            {--s|system : With core compile}';

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

        $modules = Module::collections(1);
        $count = (!$this->argument('module'))?count($modules):1;
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
