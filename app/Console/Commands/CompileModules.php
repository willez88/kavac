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
        $this->info("Compilando assets de módulos");

        foreach (Module::collections(1) as $module) {
            echo $module->getName() ."\n";
            $result = shell_exec("cd modules/$module && npm run dev");
            echo $result;
        }
        //dd();
        return 0;
    }
}
