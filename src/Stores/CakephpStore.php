<?php 

namespace CakephpFactoryMuffin\Stores;

use Cake\ORM\TableRegistry;
use League\FactoryMuffin\Stores\ModelStore;
use League\FactoryMuffin\Stores\StoreInterface;

class CakephpStore extends ModelStore implements StoreInterface
{
    /**
     * Save our object to the db, and keep track of it.
     *
     * @param object $entity The model instance.
     * @return mixed
     */
    protected function save($entity)
    {
        $alias = $entity->getSource();
        $table = TableRegistry::get($alias);
        return $table->save($entity);
    }

    /**
     * Delete our object from the db.
     *
     * @param object $entity The model instance.
     * @return mixed
     */
    protected function delete($entity)
    {
        $alias = $entity->getSource();
        $table = TableRegistry::get($alias);
        return $table->delete($entity);
    }
}
