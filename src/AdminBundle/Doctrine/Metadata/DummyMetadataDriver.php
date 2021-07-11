<?php

namespace Rabble\AdminBundle\Doctrine\Metadata;

use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\Mapping\Driver\MappingDriver;

class DummyMetadataDriver implements MappingDriver
{
    /**
     * @param string $className
     */
    public function loadMetadataForClass($className, ClassMetadata $metadata)
    {
    }

    /**
     * @return string[]
     */
    public function getAllClassNames()
    {
        return [];
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function isTransient($className)
    {
        return false;
    }
}
