<?php

namespace Picqer\Xero\Entities;

use Picqer\Xero\Exceptions\InvalidArgumentException;
use Picqer\Xero\Exceptions\RuntimeException;
use DateTime;

abstract class BaseEntity {

    protected $endpoint;
    protected $primaryKey;
    protected $childEntities = [];

    /**
     * Set property on entity
     * @param mixed $propertyName
     * @param mixed $value
     * @return void
     */
    public function __set($propertyName, $value)
    {
        if ( ! property_exists($this, $propertyName))
        {
            throw new InvalidArgumentException(
                sprintf(
                    '%s does not have a property named %s',
                    get_class($this),
                    $propertyName
                )
            );
        }

        $this->$propertyName = $value;
    }

    /**
     * Get property on entity
     * @param mixed $propertyName
     * @return mixed
     */
    public function __get($propertyName)
    {
        if ( ! property_exists($this, $propertyName))
        {

            throw new InvalidArgumentException(
                sprintf(
                    '%s does not have a property named %s',
                    get_class($this),
                    $propertyName
                )
            );
        }

        return $this->$propertyName;
    }

    public static function makeCollectionFromResponse($entityName, $data)
    {
        $collection = [];
        foreach ($data as $entityData)
        {
            $collection[] = self::makeFromResponse($entityName, $entityData);
        }
        return $collection;
    }

    public static function makeFromResponse($entityName, $data)
    {
        $entityName = '\Picqer\Xero\Entities\\' . $entityName;
        $entity = new $entityName();

        if ( ! ($entity instanceof BaseEntity))
        {
            throw new RuntimeException(
                sprintf(
                    'Object "%s" must extend Entity',
                    $entityName
                )
            );
        }

        foreach ($data as $propertyKey => $propertyValue)
        {
            if ($entity->isChildEntity($propertyKey))
            {
                $childEntityName = $entity->getChildEntityName($propertyKey);
                $childCollection = [];
                foreach ($propertyValue as $childProperty)
                {
                    $childCollection[] = self::makeFromResponse($childEntityName, $childProperty);
                }
                $entity->$propertyKey = $childCollection;
            } elseif (property_exists($entity, $propertyKey))
            {
                if (is_string($propertyValue) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $propertyValue))
                {
                    $entity->$propertyKey = new DateTime($propertyValue);
                } else
                {
                    $entity->$propertyKey = $propertyValue;
                }
            }
        }

        return $entity;
    }

    public function getPrimaryKey()
    {
        return $this->$this->primaryKey;
    }

    public function getChildEntities()
    {
        return $this->childEntities;
    }

    public function isChildEntity($key)
    {
        return array_key_exists($key, $this->getChildEntities());
    }

    public function getChildEntityName($key)
    {
        $entities = $this->getChildEntities();
        $entityname = $entities[$key];
        return $entityname;
    }
}