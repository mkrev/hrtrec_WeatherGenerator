<?php
require 'autoload.php';

use WeatherGenerator\App;

(new App($_POST))->run();
