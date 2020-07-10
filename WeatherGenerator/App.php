<?php

namespace WeatherGenerator;

use Exception;

class App
{
    protected $api_key = '7e2f3a0a4fe13ac4306c9609e4de06cf';
    protected $post;
    protected $fileCreator;

    public function __construct($post, $filename = 'cities')
    {
        $this->post = $post;
        $this->fileCreator = new FileCreator($this->getCreator(), $filename);
    }

    public function run()
    {
        $data = $this->getWeather();
        if ($data) {
            $this->generate($data);
        }
        return false;
    }

    protected function getWeather()
    {
        $app = new API($this->api_key);
        $app->setCities($this->post['cities']);
        try {
            $data = $app->getWeather();
        } catch (Exception $e) {
            echo ($e->getMessage());
            return false;
        }
        unset($this->post['cities']);
        if (empty($data['cities'])) {
            echo 'Brak poprawnego kraju';
            return false;
        }
        return $data;
    }

    protected function generate($data)
    {
        $generator = new WeatherReportGenerator($this->fileCreator, $this->post, $data);
        $generator->download();
    }

    protected function getCreator(): CreatorInterface
    {
        return new CSVCreator();
    }

    public function setApiKey($key)
    {
        $this->api_key = $key;
    }
}
