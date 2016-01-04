<?php

namespace Concrete\Core\Attribute\Category;

use Concrete\Core\Attribute\Key\Factory;
use Concrete\Core\Entity\Attribute\Type;
use Concrete\Core\Entity\Attribute\Key\Key as AttributeKey;
use Concrete\Core\Entity\Express\Attribute;
use Concrete\Core\Entity\Express\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class ExpressCategory extends AbstractCategory
{

    public function getAttributeRepository()
    {
        return $this->entityManager->getRepository('\Concrete\Core\Entity\Express\Attribute');
    }

    public function addFromRequest(Type $type, Request $request)
    {
        $key = parent::addFromRequest($type, $request);

        // Take our newly minted TextAttributeKey, SelectAttributeKey, etc... and pass it to the
        // category so it can be properly assigned in whatever way the category chooses to do so

        $attribute = new Attribute();
        $attribute->setAttributeKey($key);
        $attribute->setEntity($this->getEntity());
        $this->entity->getAttributes()->add($attribute);
        $this->entityManager->persist($this->getEntity());
        $this->entityManager->flush();
    }

    public function updateFromRequest(AttributeKey $key, Request $request)
    {
        $key = parent::updateFromRequest($key, $request);
        $this->entityManager->persist($key);
        $this->entityManager->flush();
    }


    public function delete(AttributeKey $key)
    {
        $query = $this->entityManager->createQuery(
            'select a from Concrete\Core\Entity\Express\Attribute a where a.attribute_key = :key'
        );
        $query->setParameter('key', $key);
        $attribute = $query->getSingleResult();
        if (is_object($attribute)) {
            $this->entityManager->remove($attribute);
            $this->entityManager->flush();
        }
    }

    public function getAttributeValues($mixed)
    {
        // TODO: Implement getAttributeValues() method.
    }

    public function getSearchIndexer()
    {
        // TODO: Implement getSearchIndexer() method.
    }

}