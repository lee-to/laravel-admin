<?php

namespace Leeto\Admin\Commands;

use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:generate {name} {--m|model=} {--t|title=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the admin models';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = 'app/Admin';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createResource();
    }



    public function createResource()
    {
        $name = ucfirst($this->ask("Controller name?"));
        $name = ucfirst($this->argument("name"));

        $model = $this->option("model");
        $title = $this->option("title") ?? $name;

        if(!$model) {
            $this->error("Model is required");

            return false;
        }

        $resource = $this->directory."/Resources/{$name}Resource.php";
        $contents = $this->getStub('Resource');
        $contents = str_replace("DummyModel", $model, $contents);
        $contents = str_replace("DummyTitle", $title, $contents);

        $this->laravel['files']->put(
            $resource,
            str_replace("Dummy", $name, $contents)
        );

        $this->line("<info>{$name}Resource file was created:</info> ".str_replace(base_path(), '', $resource));

        $controller = $this->directory."/Controllers/{$name}Controller.php";
        $contents = $this->getStub('ResourceController');

        $this->laravel['files']->put(
            $controller,
            str_replace("Dummy", $name, $contents)
        );

        $this->line("<info>{$name}Controller file was created:</info> ".str_replace(base_path(), '', $controller));
    }

    /**
     * Get stub contents.
     *
     * @param $name
     *
     * @return string
     */
    protected function getStub($name)
    {
        return $this->laravel['files']->get(__DIR__."/stubs/$name.stub");
    }

    /**
     * Make new directory.
     *
     * @param string $path
     */
    protected function makeDir($path = '')
    {
        $this->laravel['files']->makeDirectory("{$this->directory}/$path", 0755, true, true);
    }
}
