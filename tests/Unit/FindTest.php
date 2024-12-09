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
    public function findBusesForwardDirectionTest(): void
    {
        $outputPath = $this->getFilePath('forwardDirectionCorrectOutput.json');
        $dataPath = $this->getFilePath('testData.json');
    
        $expected = file_get_contents($outputPath);
        $data = json_decode(file_get_contents($dataPath), true);
    
        $request = [1, 4];

        Carbon::setTestNow(Carbon::today()->setTime(11, 0, 0));

        $route = new Route();
        $this->assertEquals($expected, $route->findBuses($data, $request));
    }
}
