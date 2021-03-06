<?php
namespace Doctrine\Uploader;


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

   public function prePersist($args) {
        $this->tryUpload($args);
    }
    
    public function preUpdate($args) {
        $this->tryUpload($args);
    }
    
    public function tryUpload($args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        
        if(array_key_exists(get_class($entity), $this->targets)) {
            $fields = $this->targets[get_class($entity)];
            foreach($fields as $field) {
                $entity->$field = $this->upload($entity, $field);
            }
        }
    }

    public function upload($entity, $field) {
        $raw = $entity->$field;
        if(null === $raw) return;
        $result = $this->fs->process($raw);
        if($result->isValid()) {
            return $result->name;
        }
        $result->clear();
        return false;
    }


}