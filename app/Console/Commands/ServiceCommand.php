<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceClassName = $this->argument('name');
        $serviceDirectory = app_path('Services'); // Specify the directory path

        if (!file_exists($serviceDirectory)) {
            mkdir($serviceDirectory, 0755, true); // Recursive directory creation
        }
        $serviceFile = app_path("Services/{$serviceClassName}.php");

        $stubsDirectory = __DIR__.'/stubs';
        $stub           = file_get_contents("{$stubsDirectory}/service.stub");
        $stub           = str_replace('DummyClass', $serviceClassName, $stub);

        if (!file_exists($serviceFile)) {
            file_put_contents($serviceFile, $stub);
            $this->info('Service created successfully!');
        } else {
            $this->error('Service already exists!');
        }
    }
}
