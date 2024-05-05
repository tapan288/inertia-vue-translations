<?php
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Middleware\SetLanguage;

uses(TestCase::class);

it('sets the chosen locale', function () {
    session()->put('language', 'de');

    (new SetLanguage())->handle(new Request(), function ($request) {
        expect(app()->getLocale())->toBe('de');

        return new Response();
    });
});
