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
    protected $signature = 'module:compile';

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

        $m = '';
        foreach (Module::collections(1) as $module) {
            $this->info("Compilando módulo: " . $module->getName());
            $result = shell_exec("cd modules/$module && npm run dev");

            echo $result;
            $m .= "$module,";
        }

        $this->info("Se han compilado los módulos [$m]");
        return 0;
    }
}
