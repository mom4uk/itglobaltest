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
    public function findBusesTest(): void
    {
        $outputPath = $this->getFilePath('correctOutput.json');
        $expected = file_get_contents($outputPath);

        $dataPath = $this->getFilePath('testData.php');
        $data = file_get_contents($dataPath); // serialization is needed

        $request = [1, 4];

        Carbon::setTestNow('11:30');

        $route = new Route();
        $this->assertEquals($expected, $route->findBuses($data, $request));
    }
}