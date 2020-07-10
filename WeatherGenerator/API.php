<?php

namespace WeatherGenerator;

use Exception;

class API
{
    protected $key;
    protected $domain = 'api.openweathermap.org';
    protected $action = '/data/2.5/weather?q=';
    protected $curl;
    protected $cities = [];

    public function __construct($key)
    {
        $this->key = $key;
        $this->curl = curl_init();
        $this->configConnection();
    }

    public function setCities(array $cities)
    {
        $this->cities = $cities;
    }

    protected function configConnection()
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    }

    public function getWeather()
    {
        $result = [];
        foreach ($this->cities as $city) {
            $result[$city] = $this->getWeatherByCity($city);
        }

        $sucessResult = array_filter($result);
        $wrongCities = array_keys(array_diff_key($result, $sucessResult));

        return ['cities' => $sucessResult, 'wrongCities' => $wrongCities];
    }

    protected function getWeatherByCity($city)
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->getUrl($city));
        $res = curl_exec($this->curl);
        if (curl_errno($this->curl)) {
            throw new Exception('Błąd w połączeniu z API');
        } else {
            $http_code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

            if ($http_code == 401) {
                throw new Exception('Błędny klucz do API');
            } else if ($http_code == 404) {
                return false;
            } else if ($http_code == 200 && $this->isValidJson($res)) {
                return json_decode($res, true);
            }
            throw new Exception("Nieznany typ błedu o kodzie {$http_code}");
        }
    }

    protected function getUrl($city)
    {
        return $this->domain . $this->action . $city . "&appid={$this->key}";
    }

    protected function isValidJson($jsonString)
    {
        json_decode($jsonString);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
