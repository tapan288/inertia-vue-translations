<?php

use Inertia\Testing\AssertableInertia;

it('contains a list of available langauages', function () {
    $response = $this->get('/')
        ->assertInertia(function (AssertableInertia $page) {
            $page->where('languages.data.0.value', 'en')
                ->where('languages.data.0.label', 'English');
        });

    $response->assertStatus(200);
});
