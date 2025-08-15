<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->security();

arch()->expect('App')
    ->toHaveMethodsDocumented()
    ->ignoring('App\Filament')
    ->toHavePropertiesDocumented()
    ->ignoring('App\Filament');

arch('controllers')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

//
