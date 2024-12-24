<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\RouteStopSequence;
use Tests\TestCase;

class RouteControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->get(route('index'));

        $response->assertOk();
    }
}
