<?php
namespace Doctrine\Uploder;

use Sirius\Upload\Handler as SiriusHandler;
use League\Flysystem\Filesystem;
use Sirius\Upload\UploadHandlerInterface;

class Handler extends SiriusHandler implements UploadHandlerInterface
{
    
    
    public function __construct(Filesystem $fs)
    {
        $container = new FlysystemContainer($fs);
        parent::__construct($container);
    }
}