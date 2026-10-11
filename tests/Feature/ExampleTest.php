<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

uses(RefreshDatabase::class);

beforeEach(function () {
    Artisan::call('db:seed');
});

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
