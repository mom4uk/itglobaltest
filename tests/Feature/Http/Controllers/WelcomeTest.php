<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomeTest extends TestCase
{

    public function testWelcome(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
