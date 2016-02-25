<?php
final class EntityManager
{
    private $objects = [];

    /**
     * @param DormerCalculation $object
     */
    public function persist($object)
    {
        $this->objects[$object->getId()] = $object;
    }

    public function flush()
    {
    }

    /**
     * @param $id
     *
     * @return object
     */
    public function find($id)
    {
        return $this->objects[$id];
    }
}
