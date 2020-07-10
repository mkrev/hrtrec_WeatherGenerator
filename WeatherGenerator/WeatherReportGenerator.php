<?php

namespace WeatherGenerator;

class WeatherReportGenerator
{
    protected $creator;
    protected $cities;
    protected $wrongCities;
    protected $settings;
    protected $handle;
    protected $mapper;
    protected $trans = [
        'id' => 'Id',
        'name' => 'Miasto',
        'lon' => 'Długość geograficzna',
        'lat' => 'Szerokość geograficzna',
        'temp' => 'Temperatura',
        'feels_like' => 'Odczucia',
        'temp_min' => 'Min. temperatura',
        'temp_max' => 'Max. temperatura',
        'pressure' => 'Ciśnienie',
        'humidity' => 'Wilgotność',
        'speed' => 'Prędkość',
        'deg' => 'Stopień',
    ];

    public function __construct($creator, array $settings, array $data)
    {
        $this->creator = $creator;
        $this->settings = $settings;
        $this->cities = $data['cities'];
        $this->wrongCities = $data['wrongCities'];
        $this->handle = fopen('cities.csv', 'w+');
        $this->configSettings();
    }

    protected function configSettings()
    {
        $baseProperty = ['id', 'name'];
        foreach ($baseProperty as $prop) {
            $this->settings[$prop] = true;
        }
    }

    public function download()
    {
        $this->generate();
        $this->creator->download();
    }

    protected function generate()
    {
        $this->creator->generate($this->getRows());
    }

    protected function getRows()
    {
        $rows = $this->getCityRows();
        array_unshift($rows, $this->getHeader());
        $errors = $this->getErrors();
        if ($errors !== false) {
            array_unshift($rows, [$errors]);
        }
        return $rows;
    }

    protected function getCityRows()
    {
        $rows = [];
        $mainNames = array_keys($this->settings);
        foreach ($this->cities as $key => $city) {
            foreach ($city as $key_row => $row) {
                if (!in_array($key_row, $mainNames)) {
                    continue;
                }
                if (is_array($row)) {
                    foreach ($row as $key_field => $field) {
                        if (in_array($key_field, $this->settings[$key_row])) {
                            $rows[$key][] = $field;
                        }
                    }
                } else {
                    $rows[$key][] = $row;
                }
            }
        }
        return $rows;
    }

    protected function getHeader()
    {
        $transKeys = array_keys($this->trans);
        $header = [];
        foreach ($this->settings as $settingName => $setting) {
            if (is_array($setting)) {
                foreach ($setting as  $param) {
                    array_push($header, in_array($param, $transKeys) ? $this->trans[$param] : $param);
                }
            } else {
                array_push($header, in_array($settingName, $transKeys) ? $this->trans[$settingName] : $settingName);
            }
        }

        return $header;
    }
    protected function getErrors()
    {
        if (!empty($this->wrongCities)) {
            return 'Tych krajów nie udało się odnaleźć: ' . implode(',', $this->wrongCities);
        }
        return false;
    }
}
