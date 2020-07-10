<?php

use WeatherGenerator\App;

class WeatherGeneratorTest extends PHPUnit_Framework_TestCase
{
    private $app;

    protected function setUp()
    {

        $post = [
            'cities' => [
                'TOKYO',
                'SEOUL',
            ],
            'main' => [
                'temp',
                'feels_like',
                'temp_min',
                'temp_max',
            ],
            'wind' => [
                'speed'
            ],
        ];

        $this->app = new App($post);
    }
    /**
     * @runInSeparateProcess
     */
    public function testRun()
    {
        $this->app->run();
        $this->assertFileExists('cities.csv');
    }

    public function testRunWithIncorrectApiKey()
    {
        ob_start();
        $this->app->setApiKey('test');
        $response = $this->app->run();
        $actualOutput = ob_get_clean();
        $this->assertSame($actualOutput, "Błędny klucz do API");
        $this->assertFalse($response);
    }

    public function testRunWithIncorrectCitiesName()
    {
        ob_start();
        $app = new App(['cities' => ['Test']]);
        $response = $app->run();
        $actualOutput = ob_get_clean();
        $this->assertSame($actualOutput, "Brak poprawnego kraju");
        $this->assertFalse($response);
    }
}
