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

    public function testFindBusesForwardDirection(): void
    {
        $outputPath = $this->getFilePath('forwardDirection/correctOutput.json');
        $dataPath = $this->getFilePath('forwardDirection/testData.json');
    
        $expected = file_get_contents($outputPath);
        $data = json_decode(file_get_contents($dataPath), true);
    
        $request = [1, 4];

        Carbon::setTestNow(Carbon::today()->setTime(11, 0, 0));

        $route = new Route();
        $this->assertEquals($expected, $route->findBuses($data, $request));
    }
    

    public function testFindBusesNextArrivalesTomorrow(): void
    {
        $outputPath = $this->getFilePath('nextArrivalesTomorrow/correctOutput.json');
        $dataPath = $this->getFilePath('forwardDirection/testData.json');
    
        $expected = file_get_contents($outputPath);
        $data = json_decode(file_get_contents($dataPath), true);
    
        $request = [1, 4];

        Carbon::setTestNow(Carbon::today()->setTime(19, 0, 0));

        $route = new Route();
        $this->assertEquals($expected, $route->findBuses($data, $request));
    }
}
