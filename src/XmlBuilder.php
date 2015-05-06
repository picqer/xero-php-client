<?php

namespace Picqer\Xero;

use SimpleXMLElement;
use DateTime;

class XmlBuilder {

    public function build(Entities\BaseEntity $entity)
    {
        $xml = new SimpleXMLElement('<' . $entity->getXmlName() . 's/>');

        $this->addChild($xml, $entity);

        return $xml->asXML();
    }

    private function addChild(SimpleXMLElement &$xmltree, Entities\BaseEntity $entity)
    {
        $xmlentitychild = $xmltree->addChild($entity->getXmlName());

        foreach ($entity->getAttributeKeys() as $attributeKey)
        {
            if ($entity->$attributeKey instanceof Entities\BaseEntity)
            {
                // Add child for foreign entity
                $this->addChild($xmlentitychild, $entity->$attributeKey);
            } elseif (is_array($entity->$attributeKey) && $entity->isChildEntity($attributeKey))
            {
                // Add subtree with childs for child entities
                $this->addCollectionChilds($attributeKey, $xmlentitychild, $entity->$attributeKey);
            } else
            {
                // Add xml child with attribute
                if ($entity->$attributeKey === true)
                    $entity->$attributeKey = 'true';

                if ($entity->$attributeKey === false)
                    $entity->$attributeKey = 'false';

                if ($entity->$attributeKey instanceof DateTime)
                    $entity->$attributeKey = $entity->$attributeKey->format(DateTime::ISO8601);

                if ( ! is_null($entity->$attributeKey) && ! in_array($attributeKey, $entity->getIgnoredPutPostValues())) // Do not include empty attributes
                    $xmlentitychild->addChild($attributeKey, htmlspecialchars($entity->$attributeKey));
            }
        }
    }

    private function addCollectionChilds($collectionName, SimpleXMLElement &$xmltree, $entities)
    {
        $xmlentitychild = $xmltree->addChild($collectionName);

        foreach ($entities as $entitychilds)
        {
            $this->addChild($xmlentitychild, $entitychilds);
        }
    }

}