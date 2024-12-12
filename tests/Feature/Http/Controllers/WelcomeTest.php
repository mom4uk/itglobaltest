<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    private string $path = __DIR__ . "/../fixtures/";

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testWelcomeData(): void
    {
        $outputPath = $this->getFilePath('welcome/correctOutput.json');
        $expected = file_get_contents($outputPath);

        $response = $this->get('/');

        $response->assertOk();
        $this->assertEquals($expected, $response->original);
    }
}
