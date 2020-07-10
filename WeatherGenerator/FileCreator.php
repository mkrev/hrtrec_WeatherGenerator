<?php

namespace WeatherGenerator;

class FileCreator
{
    protected $creator;

    public function __construct(CreatorInterface $creator, $ilename)
    {
        $creator->init($ilename);
        $this->creator = $creator;
    }

    public function generate($rows)
    {
        $this->creator->generate($rows);
    }

    public function download()
    {
        $this->creator->download();
    }
}
