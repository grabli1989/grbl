<?php

namespace Modules\Providers;

use Composer\Autoload\ClassMapGenerator;
use Illuminate\Config\Repository;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function register(): void
    {
        $config = $this->instanceModules();
        $this->loadPackages($config);

        foreach ($config->all() as $moduleConfig) {
            $this->registerProviders($moduleConfig['providers']);
        }

        $this->loadCommands($config);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * @param  Repository  $config
     * @return void
     */
    private function loadPackages(Repository $config): void
    {
        $files = $this->getModuleConfigFiles();

        foreach ($files as $key => $path) {
            $config->set($key, require $path);
        }
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  SplFileInfo  $file
     * @param  string  $configPath
     * @return string
     */
    private function getNestedDirectory(SplFileInfo $file, string $configPath): string
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested);
        }

        return $nested;
    }

    /**
     * @return array
     */
    private function getModuleConfigFiles(): array
    {
        $files = [];

        $packagesPath = __DIR__.'/../../..';

        foreach (Finder::create()->files()->name('module.php')->in($packagesPath) as $file) {
            $directory = $this->getNestedDirectory($file, $packagesPath);

            $files[$directory] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * @param $providers
     * @return void
     */
    private function registerProviders($providers): void
    {
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * @return Repository
     */
    private function instanceModules(): Repository
    {
        $this->app->instance('modules', $config = new Repository([]));

        return $config;
    }

    /**
     * @throws ReflectionException
     */
    private function loadCommands(Repository $config)
    {
        $dirs = [];
        foreach ($config->all() as $module) {
            $dirs = array_merge($dirs, $module['commands'] ?? []);
        }

        $commands = [];
        foreach ($dirs as $dir) {
            if ($this->folderExist($dir)) {
                $commands = array_merge($commands, array_flip(ClassMapGenerator::createMap($dir)));
            }
        }

        ksort($commands, SORT_NATURAL);

        foreach ($commands as $command) {
            $this->resolveCommand($command);
        }
    }

    /**
     * @param $folder
     * @return bool
     */
    private function folderExist($folder): bool
    {
        $path = realpath($folder);

        return $path !== false && is_dir($path);
    }

    /**
     * @param  string  $command
     * @return void
     *
     * @throws ReflectionException
     */
    private function resolveCommand(string $command): void
    {
        if ($this->isSubClassCommand($command) && ! $this->isAbstract($command)) {
            Artisan::starting(function ($artisan) use ($command) {
                $artisan->resolve($command);
            });
        }
    }

    /**
     * @param  string  $command
     * @return bool
     *
     * @throws ReflectionException
     */
    private function isAbstract(string $command): bool
    {
        return (new ReflectionClass($command))->isAbstract();
    }

    /**
     * @param  string  $command
     * @return bool
     */
    private function isSubClassCommand(string $command): bool
    {
        return is_subclass_of($command, Command::class);
    }
}
