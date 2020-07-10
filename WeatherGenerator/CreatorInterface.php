<?php

namespace WeatherGenerator;

interface CreatorInterface
{
    public function init($filename);
    public function download();
    public function generate($rows);
}
