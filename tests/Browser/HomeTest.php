<?php

declare(strict_types=1);

it('can access the home page', function (): void {
    $response = visit('/');

    $response->assertSee('Laravel has an incredibly rich ecosystem.');
});
