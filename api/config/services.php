<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Application\DataTransformer\ClubInputDataTransformer;
use App\Domain\Repository\CityRepositoryInterface;
use App\Infrastructure\Api\Geo\CityRepository;
use App\Infrastructure\Api\Geo\CityRepositoryCache;

return function (ContainerConfigurator $configurator) {
    // default configuration for services in *this* file
    $services = $configurator->services()
        ->defaults()
            ->private()
            ->autowire()      // Automatically injects dependencies in your services.
            ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    $services
        ->load('App\\', '../src/*')
        ->exclude('../src/{DependencyInjection,Entity,Migrations,Tests,Kernel.php}')
    ;

    /*
     * Alias
     */
    $services
        ->alias(CityRepositoryInterface::class, CityRepositoryCache::class)
    ;

    /*
     * Decorator
     */
    $services
        ->set(CityRepositoryCache::class)
        ->decorate(CityRepository::class)
        ->bind(CityRepositoryInterface::class, ref(CityRepositoryCache::class . ".inner"))
    ;
};
