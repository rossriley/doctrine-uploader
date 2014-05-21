<?php
namespace Doctrine\Uploader;

use Sirius\Upload\Handler;


class Listener {

    public $fs;
    public $targets;

    /**
     * Constructor function
     *
     * @param Filesystem
     * @param $targets - an array keyed on Entity name, eg: My\Entity=>[field1,field2]
     **/

    public function __construct(Handler $fs, $targets = []) {
        $this->fs = $fs;
        $this->targets = $targets;
    }

    public function preUpdate($args) {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        
        if(array_key_exists(get_class($entity), $this->targets)) {
            $fields = $this->targets[get_class($entity)];
            foreach($fields as $field) {
                $this->upload($entity, $field);
            }
        }

        if ($entity instanceof Entity\Dealer && is_array($entity->logo)) {
            $entity->logo = $this->upload($entity, "logo");
        }
        
        if ($entity instanceof Entity\Dealer && is_array($entity->image)) {
            $entity->image = $this->upload($entity, "image");
        }



    }

    public function upload($entity, $field) {
        $raw = $entity->$field;
        $result = $this->fs->process($raw);
        if($result->isValid()) {
            return $result->name;
        }
        $result->clear();
        return false;
    }


}