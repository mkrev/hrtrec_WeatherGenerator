<?php

namespace WeatherGenerator;


class CSVCreator implements CreatorInterface
{
    protected $filename;
    protected $handle;

    public function init($filename)
    {
        $this->filename = $filename . ".csv";
        $this->handle = fopen($this->filename, 'w+');
    }
    public function generate($rows)
    {
        foreach ($rows as $row) {
            fputcsv($this->handle, $row);
        }
        fclose($this->handle);
    }
    public function download()
    {
        header('Content-Type: application/csv');
        header("Content-Disposition:attachment;filename={$this->filename}");
        readfile($this->filename);
    }
}
