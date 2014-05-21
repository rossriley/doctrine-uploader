### Doctrine Uploader

This is a very basic composer package designed to slot into an existing Doctrine ORM based project.

The listener takes care of handling file uploads and saves the resulting path to the Entity.


#### How to bootstrap

1. Define your entity targets.
This is an array in the format Entity\Class=>[field1,field2] for example.
```
$targets = [
    'Myproject\Entity\User' => ['logo','profilepic'],
    'Myproject\Entity\Company' => ['logo']
];
```

2. Provide a filesystem handler
This project uses siriusphp/upload to handle uploads and Flysystem(http://flysystem.thephpleague.com) to handle saves. The simplest usage is as follows.

```
$fsAdapter = new League\Flysystem\Adapter\Local('/path/to/save');
$filesystem = new League\Flysystem\Filesystem($fsAdapter);
$handler = Handler($filesystem);
```


3. Add the listener to your EntityManager setup with the above setup

```
use Doctrine\Uploader\Listener;

$em->getEventManager()->addEventListener([Doctrine\ORM\Events::preUpdate], new Listener($handler, $targets));

```

4. Putting it all together.

```
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Doctrine\Uploader\Listener;
use Doctrine\Uploader\Handler;

$targets = [
    'Myproject\Entity\User' => ['logo','profilepic'],
    'Myproject\Entity\Company' => ['logo']
];

$fsAdapter = new Local('/path/to/save');
$filesystem = new Filesystem($fsAdapter);
$handler = Handler($filesystem);

$em->getEventManager()->addEventListener([Doctrine\ORM\Events::preUpdate], new Listener($handler, $targets));

```