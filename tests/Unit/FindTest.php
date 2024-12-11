<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Route;
use Carbon\Carbon;

class FindTest extends TestCase
{
    private string $path = __DIR__ . "/../fixtures/";

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    /** @test */
    public function findBusesForwardTest(): void
    {
        $outputPath = $this->getFilePath('correctOutput.json');
        $dataPath = $this->getFilePath('testData');
    
        $expected = file_get_contents($outputPath);
        $data = json_decode(file_get_contents($dataPath), true);
    
        $request = [1, 4];

        Carbon::setTestNow(Carbon::create(2001, 5, 21, 11));

        $route = new Route();
        $this->assertEquals($expected, $route->findBuses($data, $request));
    }
}
