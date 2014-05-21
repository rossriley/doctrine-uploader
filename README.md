### Doctrine Uploader

This is a very basic composer package designed to slot into an existing Doctrine ORM based project.

The listener takes care of handling file uploads and saves the resulting path to the Entity.


#### How to bootstrap

1. Add the listener to your EntityManager setup

```
use Doctrine\Uploader\Listener;

$em->getEventManager()->addEventListener([Doctrine\ORM\Events::preUpdate], new Listener($filesystem, $targets));

```