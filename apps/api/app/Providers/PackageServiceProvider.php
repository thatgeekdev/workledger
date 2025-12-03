<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;


class PackageServiceProvider extends ServiceProvider
{
public function boot()
{
// migrations shared
$sharedMigrations = base_path('../../packages/shared/database/migrations');
if (is_dir($sharedMigrations)) {
$this->loadMigrationsFrom($sharedMigrations);
}


// se houver seeders em infra/db ou packages, podes carregar aqui
}


public function register()
{
// se precisares bind de interfaces para implementações nos packages
}
}