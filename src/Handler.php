<?php

namespace Doctrine\Uploder;
use Sirius\Upload\Handler;
use League\Flysystem\Filesystem;

class Handler extends SiriusHandler;
{
    
    
    public function __construct(Filesystem $fs)
    {
        $container = new FlysystemContainer($fs);
        parent::__construct($container);
    }
}