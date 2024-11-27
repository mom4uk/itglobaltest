<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Route;

class FindTest extends TestCase
{
    private string $path = __DIR__ . "/../fixtures/";

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    /** @test */
    public function findBusesTest(): void
    {
        $path = $this->getFilePath('correctOutput.json');
        $expected = file_get_contents($path);
        // 1 и 2 маршруты пересекаются на остановках Колчака и Попова, Попова есть еще и в 3
        $data = ['from' => 7, 'to' => 12];
        $route = new Route();
        $this->assertEquals($expected, $route->findBuses($data));
    }
}
